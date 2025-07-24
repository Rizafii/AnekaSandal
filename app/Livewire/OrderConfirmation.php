<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderConfirmation extends Component
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
            'deliveryProof' => 'required|image|max:2048', // 2MB max
        ]);

        if ($this->order->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }

        if ($this->order->status !== 'sedang_dikirm') {
            session()->flash('error', 'Pesanan tidak dapat dikonfirmasi.');
            return;
        }

        // Store the delivery proof image
        $deliveryProofPath = $this->deliveryProof->store('delivery-proofs', 'public');

        $this->order->update([
            'status' => 'selesai',
            'received_at' => now(),
            'delivery_proof' => $deliveryProofPath
        ]);

        $this->showModal = false;
        session()->flash('success', 'Pesanan berhasil dikonfirmasi sebagai diterima.');

        // Refresh the page or emit event to parent component
        return redirect()->route('orders.show', $this->order->id);
    }

    public function render()
    {
        return view('livewire.order-confirmation');
    }
}
