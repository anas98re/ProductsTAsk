<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\JsonResponeService;
use App\Services\ProductService;
use Illuminate\Auth\Access\AuthorizationException;

class ProductController extends JsonResponeService
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        try {
            $this->authorize('viewAny', Product::class);
        } catch (AuthorizationException $e) {
            return $this->sendForbiddenResponse('You are not authorized to view all products');
        }
        return $this->productService->getAllProductsService();
    }

    public function store(StoreProductRequest $request)
    {
        return $this->productService->addProductsService($request);
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
