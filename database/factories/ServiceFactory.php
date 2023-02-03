<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Groupement;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
  'service_libcourt' => $this->faker->text(5),
  'service_liblong'  => $this->faker->text(5),
  'groupement_id'    => Groupement::factory()->create()->id,
           //
        ];
    }
}
