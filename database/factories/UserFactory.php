<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $types = ['gold', 'normal', 'silver'];
        return [
            'name' => $this->faker->name(),
            'username' => $this->faker->userName(),
            'password' => bcrypt('password'),
            'avatar' => 'default.jpg',
            'type' => $this->faker->randomElement($types),
            'is_active' => true,
        ];
    }
}
