<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductVariant;
use App\Models\Products;
use App\Models\Cart;
use App\Models\Testimonial;

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
        $this->loadTestimonials();
    }

    protected function loadTestimonials()
    {
        $testimonials = Testimonial::with('user')
            ->where('product_id', $this->product['id'])
            // ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'user' => [
                        'name' => $testimonial->user->full_name ?? 'User'
                    ],
                    'rating' => $testimonial->rating,
                    'review' => $testimonial->review,
                    'image_path' => $testimonial->image_path,
                    'created_at' => $testimonial->created_at->toISOString()
                ];
            })
            ->toArray();

        $this->product['testimonials'] = $testimonials;
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
        // Check if user is authenticated
        if (!auth()->check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
            return redirect()->route('login');
        }

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

        // Find variant
        $variant = ProductVariant::where('product_id', $this->product['id'])
            ->where('size', $this->selectedSize)
            ->where('color', $this->selectedColor)
            ->first();

        if (!$variant) {
            session()->flash('error', 'Varian produk tidak ditemukan.');
            return;
        }

        // Check if item already exists in cart
        $existingCart = Cart::where('user_id', auth()->id())
            ->where('product_id', $this->product['id'])
            ->where('variant_id', $variant->id)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $this->quantity;
            if ($newQuantity > $variant->stock) {
                session()->flash('error', 'Total jumlah melebihi stok yang tersedia.');
                return;
            }
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product['id'],
                'variant_id' => $variant->id,
                'quantity' => $this->quantity
            ]);
        }

        session()->flash('success', "Produk {$this->product['name']} (Ukuran: {$this->selectedSize}, Warna: {$this->selectedColor}) berhasil ditambahkan ke keranjang.");
    }

    public function buyNow()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            session()->flash('error', 'Silakan login terlebih dahulu untuk melakukan pembelian.');
            return redirect()->route('login');
        }

        if (!$this->selectedSize || !$this->selectedColor) {
            session()->flash('error', 'Silakan pilih ukuran dan warna terlebih dahulu.');
            return;
        }

        if ($this->currentStock === 0) {
            session()->flash('error', 'Stok untuk varian ini sedang habis.');
            return;
        }

        // Find variant
        $variant = ProductVariant::where('product_id', $this->product['id'])
            ->where('size', $this->selectedSize)
            ->where('color', $this->selectedColor)
            ->first();

        if (!$variant) {
            session()->flash('error', 'Varian produk tidak ditemukan.');
            return;
        }

        // Store in session for checkout
        $buyNowData = [
            'product_id' => $this->product['id'],
            'variant_id' => $variant->id,
            'quantity' => $this->quantity
        ];

        session(['buy_now' => $buyNowData]);

        return redirect()->route('checkout.index');
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
