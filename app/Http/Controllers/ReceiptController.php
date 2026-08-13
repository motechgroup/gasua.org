<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function downloadPdf(string $reference, ReceiptService $receiptService)
    {
        $donation = Donation::with(['campaign', 'p2pFundraiser', 'talent', 'paymentGateway'])
            ->where('transaction_reference', $reference)
            ->firstOrFail();

        $pdf = $receiptService->generatePdfStream($donation);

        return $pdf->download("Receipt-{$donation->transaction_reference}.pdf");
    }

    public function verifyQr(string $hash, ReceiptService $receiptService)
    {
        $receipt = $receiptService->verifyQrHash($hash);

        if (!$receipt) {
            return response()->view('errors.404', ['message' => 'Invalid or forged receipt verification code.'], 404);
        }

        return view('receipts.verify', [
            'receipt' => $receipt,
            'donation' => $receipt->donation,
        ]);
    }
}
