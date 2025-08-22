<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * [Display a listing of the resource.]
     *
     * @return [\Inertia\Response]
     * 
     */
    public function index(): \Inertia\Response
    {
        $products = Product::all();
        return Inertia::render('products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * [Show the form for creating a new resource.]
     *
     * @return [\Inertia\Response]
     * 
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('products/Create');
    }

    /**
     * [Store a newly created resource in storage.]
     *
     * @param Request $request
     * 
     * @return [\Illuminate\Http\RedirectResponse]
     * 
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
    /**
     * [Show the form for editing the specified resource.]
     *
     * @param Product $product
     * 
     * @return [\Inertia\Response]
     * 
     */
    public function edit(Product $product)
    {
        return Inertia::render('products/Edit', compact('product'));
    }

    /**
     * [Update the specified resource in storage.]
     *
     * @param Request $request
     * @param Product $product
     * 
     * @return [\Illuminate\Http\RedirectResponse]
     * 
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);        
        $product->update($data);    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * [Remove the specified resource from storage.]
     *
     * @param Product $product
     * 
     * @return [\Illuminate\Http\RedirectResponse]
     * 
     */
    public function delete(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.'); 
    }
}
