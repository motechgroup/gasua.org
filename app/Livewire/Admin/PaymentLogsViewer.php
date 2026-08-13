<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentLog;
use App\Models\WebhookLog;
use App\Services\Payments\PaymentManagerService;

class PaymentLogsViewer extends Component
{
    public $activeTab = 'webhooks';

    public function retryWebhook($id)
    {
        $log = WebhookLog::findOrFail($id);
        $paymentManager = app(PaymentManagerService::class);
        $paymentManager->handleWebhook($log->gateway_code, $log->payload ?? []);
        $log->increment('retry_count');
    }

    public function render()
    {
        $paymentLogs = PaymentLog::with('donation')->latest()->take(30)->get();
        $webhookLogs = WebhookLog::latest()->take(30)->get();

        return view('livewire.admin.payment-logs-viewer', [
            'paymentLogs' => $paymentLogs,
            'webhookLogs' => $webhookLogs,
        ])->layout('components.layouts.admin', ['headerTitle' => 'Payment & Webhook Audit Logs']);
    }
}
