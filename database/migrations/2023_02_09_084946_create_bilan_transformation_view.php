<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW fanlabdb.bilan_transformation 
        
        AS

        SELECT `users`.`id` as `user_id`, `users`.`name`, `users`.`prenom`, 
        `users`.`taux_de_transformation` as `taux_transfo_global`, `secteurs`.`secteur_libcourt`,
        `services`.`service_libcourt`, `groupements`.`groupement_libcourt`,
        `grades`.`grade_libcourt`,`diplomes`.`diplome_libcourt`, 
        `specialites`.`specialite_libcourt`, `fonctions`.`id` as `fonction_id`, 
        `fonctions`.`fonction_liblong`, `fonctions`.`fonction_libcourt`, 
        `user_fonction`.`taux_de_transformation` as `taux_transfo_fonction`, `user_fonction`.`date_lache`, 
        `user_fonction`.`valideur_lache`, `user_fonction`.`commentaire_lache`, 
        `user_fonction`.`date_double`, `user_fonction`.`valideur_double`, 
        `user_fonction`.`commentaire_double`, `user_fonction`.`validation`,
        `compagnonages`.`id` as `comp_id` , `compagnonages`.`comp_libcourt`, 
        `compagnonages`.`comp_liblong`, `taches`.`id` as `tache_id`, `taches`.`tache_liblong`, 
        `taches`.`tache_libcourt`, `objectifs`.`objectif_liblong`, 
        `objectifs`.`objectif_libcourt`, `sous_objectifs`.`id` as `ssobj_id`, 
        `sous_objectifs`.`ssobj_duree`, `sous_objectifs`.`ssobj_coeff`, 
        `sous_objectifs`.`ssobj_lib`, `user_sous_objectif`.`date_validation`, 
        `user_sous_objectif`.`valideur`, `user_sous_objectif`.`commentaire`,
        `type_fonctions`.`typfonction_libcourt`
        
        
        FROM `users` 
        LEFT JOIN `user_fonction` 
        ON `users`.`id` = `user_fonction`.`user_id` 
        
        LEFT JOIN `secteurs` 
        ON `secteurs`.`id` = `users`.`secteur_id`
        
        LEFT JOIN `services` 
        ON `services`.`id` = `secteurs`.`service_id`
        
        LEFT JOIN `groupements` 
        ON `groupements`.`id` = `services`.`groupement_id`
        
        LEFT JOIN `grades` 
        ON `grades`.`id` = `users`.`grade_id`
        
        LEFT JOIN `diplomes` 
        ON `diplomes`.`id` = `users`.`diplome_id`
        
        LEFT JOIN `specialites` 
        ON `specialites`.`id` = `users`.`specialite_id`
        
        LEFT JOIN `fonctions` 
        ON `fonctions`.`id` = `user_fonction`.`fonction_id` 
        
        LEFT JOIN `compagnonage_fonction` 
        ON `compagnonage_fonction`.`fonction_id` = `fonctions`.`id` 
        
        LEFT JOIN `compagnonages` 
        ON `compagnonages`.`id` = `compagnonage_fonction`.`compagnonage_id`
        
        LEFT JOIN `compagnonage_tache` 
        ON `compagnonages`.`id` = `compagnonage_tache`.`compagnonage_id`
        
        LEFT JOIN `taches` 
        ON `taches`.`id` = `compagnonage_tache`.`tache_id`
        
        LEFT JOIN `tache_objectif` 
        ON `taches`.`id` = `tache_objectif`.`tache_id`
        
        LEFT JOIN `objectifs` 
        ON `objectifs`.`id` = `tache_objectif`.`objectif_id`
        
        LEFT JOIN `sous_objectifs` 
        ON `objectifs`.`id` = `sous_objectifs`.`objectif_id`
        
        LEFT JOIN `type_fonctions` 
        ON `fonctions`.`typefonction_id` = `type_fonctions`.`id`
        
        LEFT JOIN `user_sous_objectif` 
        ON `user_sous_objectif`.`sous_objectif_id` = `sous_objectifs`.`id` AND `user_sous_objectif`.`user_id` = `users`.`id`
        
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bilan_transformation_view');
    }
};
