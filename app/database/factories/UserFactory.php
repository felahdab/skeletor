<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $grade_id = Grade::where('id', '>', 12)->pluck('id')->all()[array_rand(Grade::where('id', '>', 12)->pluck('id')->all())];
        $secteur_id = Secteur::all()->pluck('id')->all()[array_rand(Secteur::all()->pluck('id')->all())];
        $diplome_id = Diplome::all()->pluck('id')->all()[array_rand(Diplome::all()->pluck('id')->all())];
        $specialite_id = Specialite::all()->pluck('id')->all()[array_rand(Specialite::all()->pluck('id')->all())];
        $date_embarq = Carbon::createFromDate(2022, array_rand([5,6,7]), array_rand(range(1,12)));
        
        $lastname = strtolower($this->faker->lastName());
        $firstname = strtolower($this->faker->firstName());
        $email = $firstname . "." . $lastname . "@intradef.gouv.fr";
        
        return [
            'name'       => $lastname,
            'prenom'       => $firstname,
            'email'      => $email,
            'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'secteur_id' => $secteur_id,
            'specialite_id' => $specialite_id,
            'grade_id'    => $grade_id,
            'unite_id'   => 2,
            'diplome_id'  => $diplome_id,
            'unite_destination_id' => null,
            'date_embarq'   => $date_embarq->toDateString(),
        ];
    }
}
