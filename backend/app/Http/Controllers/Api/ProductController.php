<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    // List (with filter)
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'category', 'has_image']);
        $products = $this->service->list($filters);
        return response()->json($products);
    }

    // Search by ID
    public function show($id)
    {
        $product = $this->service->show($id);
        if (!$product) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return response()->json($product);
    }

    // Create
    public function store(ProductRequest $request)
    {
        $product = $this->service->create($request->validated());
        return response()->json($product, 201);
    }

    // Update
    public function update(ProductRequest $request, Product $product)
    {
        $updated = $this->service->update($product, $request->validated());
        return response()->json($updated);
    }

    // Delete
    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return response()->json([], 204);
    }
}
