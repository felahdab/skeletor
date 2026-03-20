<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MindefConnectUser>
 */
class MindefConnectUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lastname = strtolower($this->faker->lastName());
        $firstname = strtolower($this->faker->firstName());
        $email = $firstname.'.'.$lastname.'@skeletor.no.tld';

        $shortrank = 'SPB';
        $displayname = strtoupper($lastname).' '.$firstname.' '.$shortrank;

        $unitesPossibles = ['RACINE/BRANCH1/BRANCHE2/COMMANDEMENT'];
        $randUnite = $unitesPossibles[array_rand($unitesPossibles)];

        return [
            'name' => $lastname,
            'prenom' => $firstname,
            'email' => $email,
            'main_department_number' => $randUnite,
            'personal_title' => 'M.',
            'rank' => 'Super Big Boss',
            'short_rank' => $shortrank,
            'display_name' => $displayname,
        ];
    }
}
