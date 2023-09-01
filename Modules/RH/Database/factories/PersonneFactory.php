<?php

namespace Modules\RH\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use App\Models\Grade;
use App\Models\Secteur;
use App\Models\Diplome;
use App\Models\Specialite;

use Modules\RH\Entities\Personne;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PersonneFactory extends Factory
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
            'display_name' => $firstname. " " . $lastname,
            'email'      => $email,
            //'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password'   => 'password',
            'secteur_id' => Secteur::query()->inRandomOrder()->first()->id,
            'specialite_id' => Specialite::query()->inRandomOrder()->first()->id,
            'grade_id'    => Grade::query()->inRandomOrder()->first()->id,
            'unite_id'   => 2,
            'diplome_id'  => Diplome::query()->inRandomOrder()->first()->id,
            'unite_destination_id' => null,
            'date_embarq'   => $date_embarq->toDateString(),
        ];
    }

    protected static function appNamespace(){
        return 'Modules\\RH\\Entities\\';
    }
}
