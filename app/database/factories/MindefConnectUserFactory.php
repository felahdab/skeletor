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
        $email = $firstname . "." . $lastname . "@intradef.gouv.fr";
        
        $shortrank = 'CV';
        $displayname = strtoupper($lastname) . " " . $firstname . " " . $shortrank;
        
        $unitesPossibles = ['MARINE/ALFAN/GTR FREMM TOULON/COMMANDEMENT',
                            'MARINE/BATIMENTS BREST/AQUITAINE/AQUITAINE A',
                            'MARINE/BATIMENTS BREST/AQUITAINE/AQUITAINE B',
                            'MARINE/BATIMENTS BREST/BRETAGNE/BRETAGNE A',
                            'MARINE/BATIMENTS BREST/BRETAGNE/BRETAGNE B',
                            'MARINE/BATIMENTS BREST/LORRAINE',
                            'MARINE/BATIMENTS BREST/NORMANDIE',
                            'MARINE/BATIMENTS TOULON/ALSACE',
                            'MARINE/BATIMENTS TOULON/AUVERGNE',
                            'MARINE/BATIMENTS TOULON/LANGUEDOC/LANGUEDOC A',
                            'MARINE/BATIMENTS TOULON/LANGUEDOC/LANGUEDOC B',
                            'MARINE/BATIMENTS TOULON/PROVENCE/PROVENCE A',
                            'MARINE/BATIMENTS TOULON/PROVENCE/PROVENCE B'];
        $randUnite = $unitesPossibles[array_rand($unitesPossibles)];

        
        return [
            'name'                      => $lastname,
            'prenom'                    => $firstname,
            'email'                     => $email,
            'main_department_number'    => $randUnite,
            'personal_title'            => 'M.',
            'rank'                      => 'Capitaine de vaisseau',
            'short_rank'                => $shortrank,
            'display_name'              => $displayname
        ];
    }
}
