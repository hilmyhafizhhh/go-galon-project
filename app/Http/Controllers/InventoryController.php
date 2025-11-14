<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // 🟦 INDEX + FILTER
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter: nama / kategori / status
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('name')->paginate(10);

        return view('admin.inventory.index', compact('products'));
    }

    // 🟩 CREATE
    public function create()
    {
        return view('admin.inventory.create');
    }

    // 🟩 STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'volume_ml' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // 🟨 EDIT
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.inventory.edit', compact('product'));
    }

    // 🟨 UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'volume_ml' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // 🟥 DESTROY
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
