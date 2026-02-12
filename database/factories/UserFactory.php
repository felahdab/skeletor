<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Grade;
use App\Models\Secteur;
use App\Models\Diplome;
use App\Models\Specialite;

use Illuminate\Support\Carbon;

use App\Service\RandomPasswordGeneratorService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date_embarq = Carbon::createFromDate(2022, array_rand([5,6,7]), array_rand(range(1,12)));
        
        $lastname = strtolower($this->faker->lastName());
        $firstname = strtolower($this->faker->firstName());
        $domain = match(config('skeletor.reseau_de_deploiement')){
            'intradef' => config('services.intradef.mail_tld'),
            'sic21' => config('services.sic21.mail_tld')
        };

        $email = $firstname . "." . $lastname . "@" . $domain;

        $password = (new RandomPasswordGeneratorService)->generateRandomString(10);
        
        return [
            'nom'       => $lastname,
            'prenom'       => $firstname,
            'display_name' => $firstname. " " . $lastname,
            'email'      => $email,
            'password'   => $password,
        ];
    }
}
