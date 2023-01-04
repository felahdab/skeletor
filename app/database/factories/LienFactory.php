<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lien>
 */
class LienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lien_lib' => $this->faker->text(5),
            'lien_image' => "",
            "lien_url" => $this->faker->text(10),
        ];
    }
}
