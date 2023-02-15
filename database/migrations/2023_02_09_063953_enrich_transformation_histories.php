<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //j'autorise null pour les user id
        // Schema::table('transformation_histories', function (Blueprint $table) {
        //     $table->string('modifying_user_id')->nullable(true)->change();
        //     $table->string('modified_user_id')->nullable(true)->change();
        // });
        // je cree les nouveaux champs user_display_name
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->string('modifying_user', 500)->nullable(true);
            $table->string('modified_user', 500)->nullable(true);
        });
        // je met à jour les nouveaux champs
        // pas possible si nouvelle base donc inutile ici ?
        // foreach(transformation_histories::all() as $enreg){
        //     $enreg->modifying_user = User->display_name($enreg->modifying_user_id);
        //     $enreg->modified_user = User->display_name($enreg->modified_user_id);
        //     $enreg->save();
        // }
        // je supprime les champs userid
        Schema::table('transformation_histories', function (Blueprint $table) {
            $table->dropColumn('modifying_user_id');
            $table->dropColumn('modified_user_id');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    
        // c'est irreversible
    };
