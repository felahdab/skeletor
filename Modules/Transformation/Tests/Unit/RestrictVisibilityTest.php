<?php

namespace Modules\Transformation\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Modules\Transformation\Entities\User as TUser;

use Illuminate\Database\Eloquent\Builder;
use Modules\Transformation\Scopes\MemeUnite;
use Modules\Transformation\Scopes\MisesPourEmploi;
use Modules\Transformation\Scopes\MemeUniteOuRenduVisible;

use Modules\Transformation\Entities\MiseEnVisibilite;

class RestrictVisibilityTest extends TestCase
{
    use RefreshDatabase;
    public $seed=true;
    
    public function testSingleUserInAUnitSeesOnlyHimself()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2
        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);
        
        TUser::addGlobalScope(new MemeUnite(TUser::query(), $newUsers[0]));

        // The said user should be alone
        $this->assertTrue(TUser::all()->count() == 1);
    }

    public function testMultipleUsersInAUnitSeeThemselves()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move two user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);
        $newUsers[1]->update(['unite_id'=> 3]);
        
        TUser::addGlobalScope(new MemeUnite(TUser::query(), $newUsers[0]));

        // The said users should be alone, and therefore 2.
        $this->assertTrue(TUser::all()->count() == 2);
    }

    public function testAUserSeesAUserFromAnotherUnitWithMpeSansDates()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);

        // We declare a MiseEnVisibilite for a user into unite 3, without dates.
        $m=new MiseEnVisibilite;
        $m->user_id=$newUsers[1]->id;
        $m->unite_id=3;
        $m->sans_dates=true;
        $m->save();

        $forUser = $newUsers[0];
        TUser::addGlobalScope(function (Builder $builder) use ($forUser) {
            new MisesPourEmploi($builder, $forUser);
        });

        // The user in unite 3 should see the user in unite_2 for which we declared a MiseEnVisibilite
        $this->assertTrue(TUser::all()->count() == 1);
    }

    public function testAUserSeesAUserFromAnotherUnitWithMpeAvecDatesValides()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);

        // We declare a MiseEnVisibilite for a user into unite 3, without dates.
        $m=new MiseEnVisibilite;
        $m->user_id=$newUsers[1]->id;
        $m->unite_id=3;
        $m->date_debut=now()->yesterday();
        $m->date_fin=now()->tomorrow();
        $m->sans_dates=false;
        $m->save();
        
        $forUser = $newUsers[0];
        TUser::addGlobalScope(function (Builder $builder) use ($forUser) {
            new MisesPourEmploi($builder, $forUser);
        });

        // The user in unite 3 should see the user in unite_2 for which we declared a MiseEnVisibilite
        $this->assertTrue(TUser::all()->count() == 1);
    }

    public function testAUserSeesNotAUserFromAnotherUnitWithMpeAvecDatesNonValides()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);

        // We declare a MiseEnVisibilite for a user into unite 3, without dates.
        $m=new MiseEnVisibilite;
        $m->user_id=$newUsers[1]->id;
        $m->unite_id=3;
        $m->date_debut=now()->add(10, 'day');
        $m->date_fin=now()->add(12, 'day');
        $m->sans_dates=false;
        $m->save();

        $this->assertTrue(MiseEnVisibilite::all()->count() == 1);

        $forUser = $newUsers[0];
        
        TUser::addGlobalScope(function (Builder $builder) use ($forUser) {
            new MisesPourEmploi($builder, $forUser);
        });

        // The user in unite 3 should not see the user in unite_2 for which we declared a MiseEnVisibilite
        // with due dates.
        $this->assertTrue(TUser::all()->count() == 0);
    }

    public function testAUserSeesUsersFromHisUnitAndWithMpe()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);

        // We declare a MiseEnVisibilite for a user into unite 3, with valid dates
        $m=new MiseEnVisibilite;
        $m->user_id=$newUsers[1]->id;
        $m->unite_id=3;
        $m->date_debut=now()->add(-1, 'day');
        $m->date_fin=now()->add(2, 'day');
        $m->sans_dates=false;
        $m->save();

        $this->assertTrue(MiseEnVisibilite::all()->count() == 1);

        $forUser = $newUsers[0];
        
        TUser::addGlobalScope(new MemeUniteOuRenduVisible($forUser));

        // The user in unite 3 should not see the user in unite_2 for which we declared a MiseEnVisibilite
        // with due dates.
        $this->assertTrue(TUser::all()->count() == 2);
    }

    public function testAUserSeesUsersFromHisUnitButNotThoseWithInvalidMpe()
    {
        $this->artisan('module:seed', ['module' => 'Transformation']);
        $newUsers = User::factory(10)->create(); // by default they get unite_id=2

        // We move one user to unite 3.
        $newUsers[0]->update(['unite_id'=> 3]);

        // We declare a MiseEnVisibilite for a user into unite 3, with valid dates
        $m=new MiseEnVisibilite;
        $m->user_id=$newUsers[1]->id;
        $m->unite_id=3;
        $m->date_debut=now()->add(-5, 'day');
        $m->date_fin=now()->add(-2, 'day');
        $m->sans_dates=false;
        $m->save();

        $this->assertTrue(MiseEnVisibilite::all()->count() == 1);

        $forUser = $newUsers[0];
        
        TUser::addGlobalScope(new MemeUniteOuRenduVisible($forUser));

        // The user in unite 3 should not see the user in unite_2 for which we declared a MiseEnVisibilite
        // with due dates.
        $this->assertTrue(TUser::all()->count() == 1);
    }
}
