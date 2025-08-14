<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderListConfirmation extends Component
{
    use WithFileUploads;

    public $order;
    public $showModal = false;
    public $deliveryProof;

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
        $this->reset('deliveryProof');
    }

    public function confirmReceived()
    {
        $this->validate([
            'deliveryProof' => 'nullable|image|max:2048',
        ]);

        if ($this->order->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        if ($this->order->status !== 'sedang_dikirim') {
            session()->flash('error', 'Pesanan tidak dapat dikonfirmasi.');
            return;
        }

        $deliveryProofPath = null;

        // Store the delivery proof image if uploaded
        if ($this->deliveryProof) {
            $deliveryProofPath = $this->deliveryProof->store('delivery-proofs', 'public');
        }

        $this->order->update([
            'status' => 'selesai',
            'received_at' => now(),
            'delivery_proof' => $deliveryProofPath
        ]);

        $this->showModal = false;
        session()->flash('success', 'Pesanan berhasil dikonfirmasi sebagai diterima.');

        // Emit event to refresh the order list
        $this->dispatch('orderConfirmed');
    }

    public function render()
    {
        return view('livewire.order-list-confirmation');
    }
}
