<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceResource extends JsonResource
{
    public function toArray($request)
    {
        $products = $this->products->map(function ($product) {
            return [
                'nameProduct' => $product->name,
                'priceProduct' => $product->price,
            ];
        });

        return [
            'nameUser' => $this->name,
            'productsCount' => $products->count(),
            'products' => $products,
        ];
    }
}
