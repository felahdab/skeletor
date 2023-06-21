<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_sous_objectifs', function (Blueprint $table) {
                $table->unsignedBigInteger('lieu_id')->nullable(true)->change();
                $table->foreign('objectif_id')->references('id')->on('transformation_objectifs')->onDelete('cascade');
                $table->foreign('lieu_id')->references('id')->on('lieux');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_fonctions', function (Blueprint $table) {
                $table->unsignedBigInteger('typefonction_id')->nullable(true)->change();
                $table->foreign('typefonction_id')->references('id')->on('transformation_type_fonctions');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_stages', function (Blueprint $table) {
                $table->unsignedBigInteger('typelicence_id')->nullable(true)->change();
                $table->foreign('typelicence_id')->references('id')->on('transformation_type_licences')->onDelete('restrict');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_tache_objectif', function (Blueprint $table) {
                $table->foreign('tache_id')->references('id')->on('transformation_taches')->onDelete('cascade');
                $table->foreign('objectif_id')->references('id')->on('transformation_objectifs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_compagnonage_tache', function (Blueprint $table) {
                $table->foreign('compagnonage_id')->references('id')->on('transformation_compagnonages')->onDelete('cascade');
                $table->foreign('tache_id')->references('id')->on('transformation_taches')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_compagnonage_fonction', function (Blueprint $table) {
                $table->foreign('compagnonage_id')->references('id')->on('transformation_compagnonages')->onDelete('cascade');
                $table->foreign('fonction_id')->references('id')->on('transformation_fonctions')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_fonction_stage', function (Blueprint $table) {
                $table->foreign('fonction_id')->references('id')->on('transformation_fonctions')->onDelete('cascade');
                $table->foreign('stage_id')->references('id')->on('transformation_stages')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_user_fonction', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('fonction_id')->references('id')->on('transformation_fonctions')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_user_stage', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('stage_id')->references('id')->on('transformation_stages')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_user_sous_objectifs', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('sous_objectif_id')->references('id')->on('transformation_sous_objectifs')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('transformation_statistiques')) {
            Schema::table('transformation_statistiques', function (Blueprint $table) {
                $table->foreign('unite_id')->references('id')->on('unites')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('transformation_statistiques', function (Blueprint $table) {
            $table->dropForeign(['unite_id']);
        });

        Schema::table('transformation_user_sous_objectif', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sous_objectif_id']);
        });

        Schema::table('transformation_user_stage', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['stage_id']);
        });

        Schema::table('transformation_user_fonction', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['fonction_id']);
        });

        Schema::table('transformation_fonction_stage', function (Blueprint $table) {
            $table->dropForeign(['fonction_id']);
            $table->dropForeign(['stage_id']);
        });

        Schema::table('transformation_compagnonage_fonction', function (Blueprint $table) {
            $table->dropForeign(['compagnonage_id']);
            $table->dropForeign(['fonction_id']);
        });

        Schema::table('transformation_compagnonage_tache', function (Blueprint $table) {
            $table->dropForeign(['compagnonage_id']);
            $table->dropForeign(['tache_id']);
        });

        Schema::table('transformation_tache_objectif', function (Blueprint $table) {
            $table->dropForeign(['tache_id']);
            $table->dropForeign(['objectif_id']);
        });

        Schema::table('transformation_stages', function (Blueprint $table) {
            $table->dropForeign(['typelicence_id']);
        });

        Schema::table('transformation_fonctions', function (Blueprint $table) {
            $table->dropForeign(['typefonction_id']);
        });

        Schema::table('transformation_sous_objectifs', function (Blueprint $table) {
            $table->dropForeign(['objectif_id']);
            $table->dropForeign(['lieu_id']);
        });
    }
};
