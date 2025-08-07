<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'supplier'])
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(request('category'), function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->when(request('supplier'), function ($query, $supplier) {
                $query->where('supplier_id', $supplier);
            })
            ->when(request('low_stock'), function ($query) {
                $query->lowStock();
            })
            ->latest()
            ->paginate(20);

        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return Inertia::render('products/index', [
            'products' => $products,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'filters' => request()->only(['search', 'category', 'supplier', 'low_stock']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return Inertia::render('products/create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        
        // Generate QR code data (in production, you'd generate actual QR codes)
        $validatedData['qr_code'] = 'QR_' . strtoupper($validatedData['sku']);
        
        $product = Product::create($validatedData);

        // Create initial stock movement if initial stock is provided
        if ($product->current_stock > 0) {
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'in',
                'quantity' => $product->current_stock,
                'previous_stock' => 0,
                'new_stock' => $product->current_stock,
                'reference' => 'INITIAL_STOCK',
                'notes' => 'Initial stock entry',
                'user_id' => auth()->id(),
                'movement_date' => now(),
            ]);
        }

        return redirect()->route('products.show', $product)
            ->with('success', 'Product created successfully with QR code generated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'supplier', 'stockMovements.user']);
        
        $recentMovements = $product->stockMovements()
            ->with('user')
            ->latest('movement_date')
            ->limit(10)
            ->get();

        return Inertia::render('products/show', [
            'product' => $product,
            'recentMovements' => $recentMovements,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $suppliers = Supplier::active()->get();

        return Inertia::render('products/edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        $previousStock = $product->current_stock;
        
        $product->update($validatedData);

        // Create stock movement if stock changed
        if ($previousStock !== (int)$validatedData['current_stock']) {
            $difference = (int)$validatedData['current_stock'] - $previousStock;
            
            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'adjustment',
                'quantity' => $difference,
                'previous_stock' => $previousStock,
                'new_stock' => (int)$validatedData['current_stock'],
                'reference' => 'STOCK_ADJUSTMENT',
                'notes' => 'Stock adjusted via product edit',
                'user_id' => auth()->id(),
                'movement_date' => now(),
            ]);
        }

        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->update(['is_active' => false]);

        return redirect()->route('products.index')
            ->with('success', 'Product deactivated successfully.');
    }
}