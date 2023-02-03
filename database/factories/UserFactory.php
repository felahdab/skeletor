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
        $email = $firstname . "." . $lastname . "@intradef.gouv.fr";
        
        return [
            'name'       => $lastname,
            'prenom'       => $firstname,
            'email'      => $email,
            //'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password'   => 'password',
            'secteur_id' => Secteur::factory()->create()->id,
            'specialite_id' => Specialite::factory()->create()->id,
            'grade_id'    => Grade::factory()->create()->id,
            'unite_id'   => 2,
            'diplome_id'  => Diplome::factory()->create()->id,
            'unite_destination_id' => null,
            'date_embarq'   => $date_embarq->toDateString(),
        ];
    }
}
