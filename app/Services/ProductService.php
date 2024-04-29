<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;

class ProductService extends JsonResponeService
{
    private $ProductRepository;
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

        return $this->sendResponse($data, 'All Products');
    }

    public function addProductsService($request)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            $fileHandled = $request->file('image')->store('Products_image', 'public');
            $input['image'] = $fileHandled;
        }
        $input['user_id'] = auth('sanctum')->user()->id;

        $data = $this->ProductRepository->create($input);
        return $this->sendResponse(ProductResource::collection($data), 'Created Done');
    }
}
