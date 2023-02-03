<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'grade_libcourt' =>$this->faker->text(5) ,
	    'grade_liblong' =>$this->faker->name(),
	    'ordre_classmt' => 1,
        ];
    }
}
