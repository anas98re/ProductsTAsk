<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $userIds = User::pluck('id')->toArray(); 

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'slug' => $this->faker->slug,
            'is_active' => $this->faker->boolean,
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}
