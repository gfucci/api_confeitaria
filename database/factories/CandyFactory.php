<?php

namespace Database\Factories;

use App\Enums\CandyEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Candy;

class CandyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candy::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $candies = [
            'name' => $this->faker->randomElement(CandyEnum::getArrayValues()),
            'price' => $this->faker->randomFloat(2, 0, 99.99)
        ];
        $candies["unit"] = CandyEnum::getUnit($candies["name"]);

        return $candies;
    }
}
