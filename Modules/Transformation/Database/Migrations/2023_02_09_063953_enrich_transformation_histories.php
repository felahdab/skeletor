<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\TransformationHistory;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('transformation_histories', function (Blueprint $table) {
        //     $table->string('modifying_user', 500)->nullable(true);
        //     $table->string('modified_user', 500)->nullable(true);
        // });

        // foreach(TransformationHistory::all() as $enreg){
        //     $enreg->modifying_user = User::find($enreg->modifying_user_id)?->display_name;
        //     $enreg->modified_user = User::find($enreg->modified_user_id)?->display_name;
        //     $enreg->save();
        // };

        // Schema::table('transformation_histories', function (Blueprint $table) {
        //     $table->dropForeign(['modifying_user_id']);
        //     $table->dropForeign(['modified_user_id']);
        //     $table->dropColumn('modifying_user_id');
        //     $table->dropColumn('modified_user_id');
        // });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    
        // c'est irreversible
    }
};
