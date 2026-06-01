<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    // 🟦 INDEX + FILTER
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter: nama / kategori / status
        if ($request->filled('search')) {
            // Mengubah 'like' menjadi 'ilike' agar kebal huruf besar/kecil (PostgreSQL)
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }

        // if ($request->filled('category')) {
        //     // Menggunakan 'ilike' agar filter 'air' tetap memunculkan data 'Air'
        //     $query->where('category', 'ilike', $request->category);
        // }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('name')->paginate(10);

        return view('admin.inventory.index', compact('products'));
    }
    //     if ($request->filled('search')) {
    //         $query->where('name', 'like', '%' . $request->search . '%');
    //     }

    //     if ($request->filled('category')) {
    //         $query->where('category', $request->category);
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     $products = $query->orderBy('name')->paginate(10);

    //     return view('admin.inventory.index', compact('products'));
    // }

    // 🟩 CREATE
    public function create()
    {
        return view('admin.inventory.create');
    }

    // 🟩 STORE
    public function store(Request $request)
    {
        // try {
            $request->validate([
            'name' => 'required',
            // 'category' => 'required',
            'volume_l' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
            // $data['image'] = $request->file('image')
            ->store('products', 'public');
            
            $data['image'] = $imagePath;
        }
            
        Product::create($data);
            
        return redirect()->route('admin.inventory.index')
        ->with('success', 'Produk berhasil ditambahkan!');

    //     } catch (\Exception $e) {

    //     dd($e->getMessage());
    // }

        // Product::create($request->all());

        // return redirect()->route('admin.inventory.index')
        //     ->with('success', 'Produk berhasil ditambahkan!');
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
            // 'category' => 'required',
            'volume_l' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($id);
        
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                }
                $imagePath = $request->file('image')
                ->store('products', 'public');
                
                $data['image'] = $imagePath;
                }
                
                $product->update($data);
                
                return redirect()->route('admin.inventory.index')
                ->with('success', 'Produk berhasil diperbarui!');

        // $product = Product::findOrFail($id);
        // $product->update($request->all());

        // return redirect()->route('admin.inventory.index')
        //     ->with('success', 'Produk berhasil diperbarui!');
    }

    // 🟥 DESTROY
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
