<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartIndex extends Component
{
    public $cartItems = [];
    public $selectedItems = [];
    public $selectAll = false;
    public $total = 0;
    public $selectedTotal = 0;
    public $selectedCount = 0;

    protected $listeners = ['cartUpdated' => 'loadCartItems'];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        $this->cartItems = Cart::with(['product.images', 'variant'])
            ->where('user_id', Auth::id())
            ->get()
            ->toArray();

        $this->total = collect($this->cartItems)->sum('subtotal');
        $this->updateSelectedTotals();
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedItems = collect($this->cartItems)->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
        $this->updateSelectedTotals();
    }

    public function updatedSelectedItems()
    {
        $totalItems = count($this->cartItems);
        $selectedCount = count($this->selectedItems);

        if ($selectedCount === $totalItems && $totalItems > 0) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }

        $this->updateSelectedTotals();
    }

    public function updateSelectedTotals()
    {
        $this->selectedCount = count($this->selectedItems);
        $this->selectedTotal = collect($this->cartItems)
            ->whereIn('id', $this->selectedItems)
            ->sum('subtotal');
    }

    public function increaseQuantity($cartId)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            // Check stock if variant exists
            if ($cartItem->variant && ($cartItem->quantity + 1) > $cartItem->variant->stock) {
                session()->flash('error', 'Stok tidak mencukupi');
                return;
            }

            $cartItem->increment('quantity');
            $this->loadCartItems();
            session()->flash('success', 'Jumlah produk berhasil ditambah');
        }
    }

    public function decreaseQuantity($cartId)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
                $this->loadCartItems();
                session()->flash('success', 'Jumlah produk berhasil dikurangi');
            }
        }
    }

    public function updateQuantity($cartId, $quantity)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $quantity = (int) $quantity;

            if ($quantity < 1) {
                return;
            }

            // Check stock if variant exists
            if ($cartItem->variant && $quantity > $cartItem->variant->stock) {
                session()->flash('error', 'Stok tidak mencukupi');
                return;
            }

            $cartItem->update(['quantity' => $quantity]);
            $this->loadCartItems();
            session()->flash('success', 'Jumlah produk berhasil diperbarui');
        }
    }

    public function removeItem($cartId)
    {
        $cartItem = Cart::find($cartId);
        if ($cartItem && $cartItem->user_id === Auth::id()) {
            $cartItem->delete();

            // Remove from selected items if it was selected
            $this->selectedItems = array_values(array_diff($this->selectedItems, [$cartId]));

            $this->loadCartItems();
            session()->flash('success', 'Item berhasil dihapus dari keranjang');
        }
    }

    public function checkout()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item yang ingin di-checkout');
            return;
        }

        // Redirect to checkout with selected items
        return redirect()->route('checkout.index', ['selected_items' => $this->selectedItems]);
    }

    public function render()
    {
        return view('livewire.cart-index');
    }
}
