<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProductService extends JsonResponeService
{
    public $ProductRepository;
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function getAllProductsService()
    {
        $data = $this->ProductRepository->all();

        if ($data->isEmpty()) {
            return $this->sendEmptyResponse('There are no products');
        }

        return $this->sendResponse(ProductResource::collection($data), 'All Products');
    }

    public function addProductsService($request)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            $fileHandled = $request->file('image')->store('Products_image', 'public');
            $input['image'] = $fileHandled;
        }
        $input['user_id'] = auth('sanctum')->user()->id;

        $product = $this->ProductRepository->create($input);

        return $this->sendResponse(new ProductResource($product), 'Created Done');
    }

    public function showProductsService($slug)
    {
        $product = $this->ProductRepository->where('slug', $slug)->first();

        if (!$product) {
            return $this->sendError('Product not found.', [], 404);
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function updateProductService($request, $slug)
    {
        $product = $this->ProductRepository->where('slug', $slug)->first();

        $product->name = $request->name ?? $request->name;
        $product->description = $request->description ?? $product->description;
        $product->price = $request->price ?? $product->price;
        $product->save();

        if ($request->hasFile('image')) {
            $fileHandled = $request->file('image')->store('Products_image', 'public');
            $product->image = $fileHandled;
            $product->save();

            Storage::delete($fileHandled);
        }

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    public function deleteProductService($slug)
    {
        $this->ProductRepository->delete('slug', $slug);
    }
}
