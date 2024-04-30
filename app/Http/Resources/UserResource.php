<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'products' => $this->products,
            'token' => $this->token,
        ];
    }
}
