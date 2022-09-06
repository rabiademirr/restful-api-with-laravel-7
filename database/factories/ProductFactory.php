<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productName = $this->faker->sentence(1);
        return [
            'name' => $productName,
            'slug' => Str::slug($productName),
            'description' =>$this->faker->paragraph(3),
            'price' =>mt_rand(10,1000),

        ];
    }
}
