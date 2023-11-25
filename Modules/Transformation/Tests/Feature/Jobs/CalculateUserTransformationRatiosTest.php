<?php

namespace Modules\Transformation\Tests\Feature\Jobs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
 


use Modules\Transformation\Entities\User;
use Modules\Transformation\Entities\Fonction;
use Modules\Transformation\Services\GererTransformationService;
use Modules\Transformation\Jobs\CalculateUserTransformationRatios;

class CalculateUserTransformationRatiosTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_calculate_taux_de_transformation()
    {
        $this->seed();
        Artisan::call('module:seed');
        Event::fake();

        $user = User::first();
        Auth::login($user);

        $fonction = Fonction::first();
        $service = new GererTransformationService();

        $this->assertTrue($user->taux_de_transformation == 0);
        $service->attachFonction($user, $fonction);

        $ssobj=$user->coll_sous_objectifs()->first();
        $service->ValidateSousObjectif($user, $ssobj, "2022-09-01", "Good job", "Admin", false);

        $job = new CalculateUserTransformationRatios($user);
        $job->handle();

        $this->assertTrue($user->taux_de_transformation != 0);
    }
}
