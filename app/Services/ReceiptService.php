<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\DonationReceipt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReceiptService
{
    public function generateReceiptRecord(Donation $donation): DonationReceipt
    {
        $receipt = DonationReceipt::where('donation_id', $donation->id)->first();
        if ($receipt) {
            return $receipt;
        }

        $qrHash = 'QR-' . strtoupper(Str::random(12));
        $receiptNumber = $donation->receipt_number ?? ('REC-' . date('Y') . '-' . str_pad((string)$donation->id, 5, '0', STR_PAD_LEFT));

        return DonationReceipt::create([
            'donation_id' => $donation->id,
            'receipt_number' => $receiptNumber,
            'pdf_path' => null,
            'qr_code_hash' => $qrHash,
            'sent_at' => now(),
        ]);
    }

    public function generatePdfStream(Donation $donation)
    {
        $receipt = $this->generateReceiptRecord($donation);
        $verifyUrl = route('receipts.verify', ['hash' => $receipt->qr_code_hash]);

        $qrImageBase64 = null;
        try {
            $qrSvg = QrCode::size(120)->format('png')->generate($verifyUrl);
            $qrImageBase64 = 'data:image/png;base64,' . base64_encode($qrSvg);
        } catch (\Exception $e) {
            // Fallback if SVG/PNG rendering engine requires extension
            $qrImageBase64 = null;
        }

        $pdf = Pdf::loadView('pdf.receipt', [
            'donation' => $donation,
            'receipt' => $receipt,
            'qrImageBase64' => $qrImageBase64,
            'verifyUrl' => $verifyUrl,
        ]);

        return $pdf;
    }

    public function verifyQrHash(string $hash): ?DonationReceipt
    {
        return DonationReceipt::with(['donation', 'donation.campaign'])->where('qr_code_hash', $hash)->first();
    }
}
