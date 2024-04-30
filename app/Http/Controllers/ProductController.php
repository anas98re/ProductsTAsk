<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\JsonResponeService;
use App\Services\ProductService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

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

    public function show($slug)
    {
        $product = $this->productService->ProductRepository->where('slug', $slug)->first();
        try {
            $this->authorize('view', $product);
            $productShow = $this->productService->showProductsService($slug);
            return $productShow;
        } catch (AuthorizationException $e) {
            return $this->sendForbiddenResponse('You are not authorized to view this product');
        }
    }


    public function update(Request $request, $slug)
    {
        $product = $this->productService->ProductRepository->where('slug', $slug)->first();

        //Only the admin whom we considered to be the gold type
        //or the owner of this product ($product->user_id === $user->id) can update it
        if (auth()->user()->type == 'gold' || $this->canUserUpdateProduct($product)) {
            $productUpdate = $this->productService->updateProductService($request, $slug);
            return $productUpdate;
        }

        return $this->sendForbiddenResponse('You are not authorized to update this product');
    }

    private function canUserUpdateProduct($product)
    {
        try {
            $this->authorize('view', $product);
            return true;
        } catch (AuthorizationException $e) {
            return false;
        }
    }

    public function destroy($slug)
    {
        $product = $this->productService->ProductRepository->where('slug', $slug)->first();

        //Only the admin whom we considered to be the gold type
        //or the owner of this product ($product->user_id === $user->id) can delete it
        if (auth()->user()->type == 'gold' || $this->canUserDeleteProduct($product)) {
            $this->productService->deleteProductService($slug);
            return $this->sendSucssas('Product deleted successfully.');
        }

        return $this->sendForbiddenResponse('You are not authorized to delete this product.');
    }

    private function canUserDeleteProduct($product)
    {
        try {
            $this->authorize('delete', $product);
            return true;
        } catch (AuthorizationException $e) {
            return false;
        }
    }
}
