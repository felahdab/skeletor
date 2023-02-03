<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Service;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Secteur>
 */
class SecteurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
  'secteur_libcourt' =>$this->faker->text(5),
  'secteur_liblong' =>$this->faker->name(),
  'service_id' => Service::factory()->create()->id,
           //
        ];
    }
}
