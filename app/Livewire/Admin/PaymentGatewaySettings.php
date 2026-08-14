<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PaymentGateway;
use Database\Seeders\PaymentGatewaySeeder;

class PaymentGatewaySettings extends Component
{
    public $editingCode = null;
    public $name = '';
    public $is_enabled = true;
    public $is_test_mode = true;
    public $is_default = false;
    public $fee_percentage = 0.00;
    public $instructions = '';
    public $credentials = [];

    public $savedMessage = false;

    public function mount()
    {
        $this->ensureGatewaysSeeded();
    }

    public function ensureGatewaysSeeded()
    {
        if (!PaymentGateway::where('code', 'stripe')->exists()) {
            app(PaymentGatewaySeeder::class)->run();
        }
    }

    public function editGateway($code)
    {
        $gw = PaymentGateway::where('code', $code)->firstOrFail();
        $this->editingCode = $gw->code;
        $this->name = $gw->name;
        $this->is_enabled = $gw->is_enabled;
        $this->is_test_mode = $gw->is_test_mode;
        $this->is_default = $gw->is_default;
        $this->fee_percentage = $gw->fee_percentage;
        $this->instructions = $gw->instructions;
        $this->credentials = $gw->credentials ?? [];
    }

    public function toggleGatewayStatus($code)
    {
        $gw = PaymentGateway::where('code', $code)->firstOrFail();
        $gw->update(['is_enabled' => !$gw->is_enabled]);
    }

    public function setDefault($code)
    {
        PaymentGateway::query()->update(['is_default' => false]);
        PaymentGateway::where('code', $code)->update(['is_default' => true]);
    }

    public function saveGateway()
    {
        $this->validate([
            'name' => 'required|string|max:100',
        ]);

        $gw = PaymentGateway::where('code', $this->editingCode)->firstOrFail();
        
        if ($this->is_default) {
            PaymentGateway::query()->update(['is_default' => false]);
        }

        $gw->name = $this->name;
        $gw->is_enabled = $this->is_enabled;
        $gw->is_test_mode = $this->is_test_mode;
        $gw->is_default = $this->is_default;
        $gw->fee_percentage = 0.00;
        $gw->instructions = $this->instructions;
        $gw->credentials = $this->credentials;
        $gw->save();

        $this->savedMessage = true;
        $this->editingCode = null;
    }

    public function render()
    {
        $this->ensureGatewaysSeeded();
        $gateways = PaymentGateway::all();

        return view('livewire.admin.payment-gateway-settings', [
            'gateways' => $gateways,
        ])->layout('components.layouts.admin', ['headerTitle' => 'Payment Gateway Configurator']);
    }
}
