<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diplome>
 */
class DiplomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'diplome_libcourt' =>$this->faker->text(5),
	    'diplome_liblong' =>$this->faker->name(),
	    'ordre_classmt' => 1,
        ];
    }
}
