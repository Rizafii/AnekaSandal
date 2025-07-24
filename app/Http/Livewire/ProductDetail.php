<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ProductVariant;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;
    public $selectedSize = null;
    public $selectedColor = null;
    public $quantity = 1;
    public $currentStock = 0;
    public $showStock = false;
    public $availableSizes = [];
    public $availableColors = [];
    public $isInWishlist = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->loadAvailableVariants();
    }

    protected function loadAvailableVariants()
    {
        // Get available sizes with their total stock
        $this->availableSizes = ProductVariant::where('product_id', $this->product['id'])
            ->selectRaw('size, SUM(stock) as total_stock')
            ->groupBy('size')
            ->orderBy('size')
            ->get()
            ->map(function ($item) {
                return [
                    'size' => $item->size,
                    'total_stock' => $item->total_stock
                ];
            })
            ->toArray();

        // Get available colors with their availability status
        $this->availableColors = ProductVariant::where('product_id', $this->product['id'])
            ->selectRaw('color, SUM(stock) as total_stock')
            ->groupBy('color')
            ->get()
            ->map(function ($item) {
                return [
                    'color' => $item->color,
                    'available' => $item->total_stock > 0
                ];
            })
            ->toArray();
    }

    public function selectSize($size)
    {
        $this->selectedSize = $size;
        $this->updateAvailableColors();
        $this->updateStock();
    }

    public function selectColor($color)
    {
        $this->selectedColor = $color;
        $this->updateAvailableSizes();
        $this->updateStock();
    }

    protected function updateAvailableColors()
    {
        if ($this->selectedSize) {
            // Update color availability based on selected size
            $this->availableColors = ProductVariant::where('product_id', $this->product['id'])
                ->where('size', $this->selectedSize)
                ->selectRaw('color, stock')
                ->get()
                ->map(function ($item) {
                    return [
                        'color' => $item->color,
                        'available' => $item->stock > 0
                    ];
                })
                ->toArray();
        }
    }

    protected function updateAvailableSizes()
    {
        if ($this->selectedColor) {
            // Update size availability based on selected color
            $this->availableSizes = ProductVariant::where('product_id', $this->product['id'])
                ->where('color', $this->selectedColor)
                ->selectRaw('size, stock as total_stock')
                ->orderBy('size')
                ->get()
                ->map(function ($item) {
                    return [
                        'size' => $item->size,
                        'total_stock' => $item->total_stock
                    ];
                })
                ->toArray();
        }
    }

    protected function updateStock()
    {
        if ($this->selectedSize && $this->selectedColor) {
            $variant = ProductVariant::where('product_id', $this->product['id'])
                ->where('size', $this->selectedSize)
                ->where('color', $this->selectedColor)
                ->first();

            $this->currentStock = $variant ? $variant->stock : 0;
            $this->showStock = true;

            // Reset quantity if it exceeds available stock
            if ($this->quantity > $this->currentStock) {
                $this->quantity = $this->currentStock > 0 ? 1 : 0;
            }
        } else {
            $this->showStock = false;
            $this->currentStock = 0;
        }
    }

    public function increaseQuantity()
    {
        if ($this->quantity < $this->currentStock) {
            $this->quantity++;
        }
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if (!$this->selectedSize || !$this->selectedColor) {
            session()->flash('error', 'Silakan pilih ukuran dan warna terlebih dahulu.');
            return;
        }

        if ($this->currentStock === 0) {
            session()->flash('error', 'Stok untuk varian ini sedang habis.');
            return;
        }

        if ($this->quantity > $this->currentStock) {
            session()->flash('error', 'Jumlah melebihi stok yang tersedia.');
            return;
        }

        // Add to cart logic here
        // You might want to create a Cart model/service to handle this
        session()->flash('success', "Produk {$this->product['name']} (Ukuran: {$this->selectedSize}, Warna: {$this->selectedColor}) berhasil ditambahkan ke keranjang.");
    }

    public function buyNow()
    {
        if (!$this->selectedSize || !$this->selectedColor) {
            session()->flash('error', 'Silakan pilih ukuran dan warna terlebih dahulu.');
            return;
        }

        if ($this->currentStock === 0) {
            session()->flash('error', 'Stok untuk varian ini sedang habis.');
            return;
        }

        // Redirect to checkout with selected variant
        return redirect()->route('checkout', [
            'product_id' => $this->product['id'],
            'size' => $this->selectedSize,
            'color' => $this->selectedColor,
            'quantity' => $this->quantity
        ]);
    }

    public function toggleWishlist()
    {
        // Toggle wishlist logic here
        $this->isInWishlist = !$this->isInWishlist;

        if ($this->isInWishlist) {
            session()->flash('success', 'Produk ditambahkan ke wishlist.');
        } else {
            session()->flash('success', 'Produk dihapus dari wishlist.');
        }
    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
