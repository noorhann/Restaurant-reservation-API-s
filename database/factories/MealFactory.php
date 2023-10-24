<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 50, 400),
            'available_quantity' => $this->faker->numberBetween(0, 20),
            'discount' => $this->faker->numberBetween(0, 30), // Percentage discount
        ];
    }
}
