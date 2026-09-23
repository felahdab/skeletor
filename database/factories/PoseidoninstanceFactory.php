<?php

namespace Database\Factories;

use App\Models\Poseidoninstance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Poseidoninstance>
 */
class PoseidoninstanceFactory extends Factory
{
    protected $model = Poseidoninstance::class;

    public function definition(): array
    {
        $name = fake()->unique()->domainWord();
        $skeletorVersion = fake()->numerify('5.##.#');
        $moduleVersions = [
            'Fleetprogram' => fake()->numerify('1.##.#'),
            'FcmCentral' => fake()->numerify('1.##.#'),
        ];

        $nodeDescription = [
            'nom' => $name,
            'details' => [
                'skeletor' => $skeletorVersion,
                'modules' => $moduleVersions,
            ],
        ];

        return [
            'uuid' => fake()->uuid(),
            'nom' => $name,
            'last_seen' => Carbon::now()->subHours(fake()->numberBetween(0, 72)),
            'data' => [],
            'node_description' => $nodeDescription,
            'versions' => $nodeDescription['details'],
        ];
    }

    public function active(): static
    {
        return $this->state([
            'last_seen' => Carbon::now()->subHours(fake()->numberBetween(0, 47)),
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'last_seen' => Carbon::now()->subHours(fake()->numberBetween(48, 168)),
        ]);
    }
}
