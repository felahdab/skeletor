<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Groupement>
 */
class GroupementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'groupement_libcourt' => $this->faker->text(5),
            'groupement_liblong' =>$this->faker->name(),
          //
        ];
    }
}
