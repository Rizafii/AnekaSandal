<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $isActive = $request->status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();

        // Generate slug from name
        $data['slug'] = Str::slug($request->name);

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = asset('storage/' . $imagePath);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $data = $request->all();

        // Generate slug from name if name changed
        if ($request->name !== $category->name) {
            $data['slug'] = Str::slug($request->name);

            // Ensure slug is unique (exclude current record)
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                $oldImagePath = str_replace(asset('storage/'), '', $category->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = asset('storage/' . $imagePath);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has products
            $productCount = $category->products()->count();
            if ($productCount > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Kategori tidak dapat dihapus karena masih memiliki {$productCount} produk terkait."
                    ], 422);
                }

                return redirect()->route('admin.categories.index')
                    ->with('error', "Kategori tidak dapat dihapus karena masih memiliki {$productCount} produk terkait.");
            }

            // Delete image if exists
            if ($category->image) {
                $imagePath = str_replace(asset('storage/'), '', $category->image);
                Storage::disk('public')->delete($imagePath);
            }

            // Delete category
            $category->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kategori berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus.');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus kategori.'
                ], 500);
            }

            return redirect()->route('admin.categories.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

    public function show(Category $category)
    {
        $category->loadCount('products');

        if (request()->expectsJson()) {
            return response()->json([
                'id' => $category->id,
                'name' => $category->name,
                'products_count' => $category->products_count
            ]);
        }

        return view('admin.categories.show', compact('category'));
    }

    public function quickCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['is_active'] = true; // Default to active for quick create

        // Generate slug from name
        $data['slug'] = Str::slug($request->name);

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name
            ]
        ]);
    }
}
