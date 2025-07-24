<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;

class RejectPaymentModal extends Component
{
    public $order;
    public $showModal = false;
    public $rejectionReason = '';

    public function mount(Order $order)
    {
        $this->order = $order;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset('rejectionReason');
    }

    public function rejectPayment()
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:10|max:500',
        ]);

        $this->order->update([
            'payment_status' => 'ditolak',
            'rejection_reason' => $this->rejectionReason,
            'rejected_at' => now()
        ]);

        $this->showModal = false;
        session()->flash('success', 'Pembayaran berhasil ditolak.');

        return redirect()->route('admin.orders.show', $this->order->id);
    }

    public function render()
    {
        return view('livewire.admin.reject-payment-modal');
    }
}
