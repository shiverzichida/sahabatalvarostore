<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'products.*.name' => 'required|string|max:255',
            'products.*.category_id' => 'required|exists:categories,id',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.description' => 'nullable|string',
        ]);

        foreach ($request->products as $item) {
            Product::create([
                'name' => $item['name'],
                'category_id' => $item['category_id'],
                'price' => $item['price'],
                'description' => $item['description'] ?? '',
                'slug' => Str::slug($item['name']) . '-' . uniqid(),
                'is_active' => true,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', count($request->products) . ' produk berhasil ditambahkan.');
    }

    public function duplicate(Product $product)
    {
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (Copy)';
        $newProduct->slug = Str::slug($newProduct->name) . '-' . uniqid();
        $newProduct->save();

        return back()->with('success', 'Produk berhasil diduplikasi.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function quickUpdate(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $product->update($request->only(['name', 'category_id', 'price']));
        return response()->json(['success' => true]);
    }

    public function updateImage(Request $request, Product $product)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $imagePath = $request->file('image')->store('products', 'public');
        $product->update(['image' => $imagePath]);

        return back()->with('success', 'Foto produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
