<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Receipt #{{ $receipt->receipt_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { border-bottom: 2px solid #16a34a; padding-bottom: 15px; margin-bottom: 20px; }
        .logo-title { font-size: 24px; font-weight: bold; color: #16a34a; text-transform: uppercase; }
        .sub-title { font-size: 12px; color: #666; margin-top: 5px; }
        .receipt-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th, .table td { padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        .table th { background: #f1f5f9; color: #475569; font-size: 12px; text-transform: uppercase; }
        .amount-highlight { font-size: 22px; font-weight: bold; color: #16a34a; }
        .footer { font-size: 11px; color: #94a3b8; text-align: center; margin-top: 30px; border-top: 1px dashed #cbd5e1; padding-top: 15px; }
        .qr-section { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo-title">GUSII ALL STARS FOUNDATION</div>
                    <div class="sub-title">Empowering Talents, Feeding Families & Transforming Communities</div>
                    <div class="sub-title">Kisii Town, Kenya | info@gusiiallstars.org | +254 700 123 456</div>
                </td>
                <td class="qr-section">
                    @if($qrImageBase64)
                        <img src="{{ $qrImageBase64 }}" width="90" height="90" alt="QR Code">
                    @endif
                    <div style="font-size: 9px; color: #64748b; margin-top: 4px;">Official Verification Code<br><strong>{{ $receipt->qr_code_hash }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 15px;">
        <h2 style="margin: 0; color: #0f172a;">OFFICIAL DONATION RECEIPT</h2>
        <p style="margin: 5px 0; color: #64748b;">Receipt #: <strong>{{ $receipt->receipt_number }}</strong> | Date: <strong>{{ $donation->created_at->format('M d, Y H:i T') }}</strong></p>
    </div>

    <div class="receipt-box">
        <table style="width: 100%;">
            <tr>
                <td>
                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase;">Donor Information</span>
                    <h4 style="margin: 5px 0; font-size: 16px;">{{ $donation->donor_name }}</h4>
                    <p style="margin: 2px 0; color: #475569;">{{ $donation->donor_email ?? 'N/A' }} | {{ $donation->donor_phone ?? 'N/A' }}</p>
                    <p style="margin: 2px 0; color: #475569;">Country: {{ $donation->donor_country }}</p>
                </td>
                <td style="text-align: right;">
                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase;">Total Received</span>
                    <div class="amount-highlight">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</div>
                    <p style="margin: 5px 0; color: #16a34a; font-weight: bold;">Status: PAYMENT VERIFIED ✓</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Transaction Ref</th>
                <th>Payment Method</th>
                <th>Donation Purpose / Campaign</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>{{ $donation->transaction_reference }}</strong></td>
                <td>{{ strtoupper($donation->gateway_code) }} ({{ $donation->payment_reference ?? 'N/A' }})</td>
                <td>
                    @if($donation->campaign)
                        <strong>Campaign:</strong> {{ $donation->campaign->title }}
                    @elseif($donation->p2pFundraiser)
                        <strong>P2P Fundraiser:</strong> {{ $donation->p2pFundraiser->title }}
                    @elseif($donation->talent)
                        <strong>Talent Support:</strong> {{ $donation->talent->name }}
                    @else
                        General Foundation Fund
                    @endif
                </td>
                <td><strong>{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if($donation->donor_message)
        <div style="margin-top: 20px; background: #fffbebf8; border-left: 4px solid #f59e0b; padding: 12px; font-style: italic;">
            "{{ $donation->donor_message }}"
        </div>
    @endif

    <div class="footer">
        <p>Thank you for your generous support! Gusii All Stars Foundation is a registered charity in Kenya.</p>
        <p>You can verify this receipt online anytime at: <a href="{{ $verifyUrl }}">{{ $verifyUrl }}</a></p>
    </div>
</body>
</html>
