<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER VIEW transformation_bilan_transformation 
        
        AS 

        SELECT `users`.`id` as `user_id`, `users`.`name`, `users`.`prenom`, 
        `users`.`taux_de_transformation` as `taux_transfo_global`, 
        `secteurs`.`secteur_libcourt`,
        `services`.`service_libcourt`, 
        `groupements`.`groupement_libcourt`,
        `grades`.`grade_libcourt`,
        `diplomes`.`diplome_libcourt`, 
        `specialites`.`specialite_libcourt`, 
        `users`.`unite_id`,
        `unites`.`unite_libcourt`,
        `transformation_fonctions`.`id` as `fonction_id`, 
        `transformation_fonctions`.`fonction_liblong`, 
        `transformation_fonctions`.`fonction_libcourt`, 
        `transformation_user_fonction`.`taux_de_transformation` as `taux_transfo_fonction`, 
        `transformation_user_fonction`.`date_lache`, 
        `transformation_user_fonction`.`valideur_lache`, 
        `transformation_user_fonction`.`commentaire_lache`, 
        `transformation_user_fonction`.`date_double`, 
        `transformation_user_fonction`.`valideur_double`, 
        `transformation_user_fonction`.`commentaire_double`, 
        `transformation_user_fonction`.`validation`,
        `transformation_compagnonages`.`id` as `compagn_id` , 
        `transformation_compagnonages`.`comp_libcourt` as `compagn_libcourt`, 
        `transformation_compagnonages`.`comp_liblong` as `compagn_liblong`, 
        `transformation_taches`.`id` as `competence_id`, 
        `transformation_taches`.`tache_liblong` as `competence_liblong`, 
        `transformation_taches`.`tache_libcourt` as `competence_libcourt`, 
        `transformation_objectifs`.`id` as `SF_id` ,
        `transformation_objectifs`.`objectif_liblong` as `SF_liblong`, 
        `transformation_objectifs`.`objectif_libcourt` as `SF_libcourt`, 
        `transformation_sous_objectifs`.`id` as `tache_id`, 
        `transformation_sous_objectifs`.`ssobj_duree` as `tache_duree`, 
        `transformation_sous_objectifs`.`ssobj_coeff` as `tache_coeff`, 
        `transformation_sous_objectifs`.`ssobj_lib` as `tache_lib`, 
        `transformation_user_sous_objectifs`.`date_validation`, 
        `transformation_user_sous_objectifs`.`valideur`, 
        `transformation_user_sous_objectifs`.`commentaire`,
        `transformation_type_fonctions`.`typfonction_libcourt`
        
        FROM `users` 
        LEFT JOIN `transformation_user_fonction` 
        ON `users`.`id` = `transformation_user_fonction`.`user_id` 
        
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

        LEFT JOIN `unites` 
        ON `unites`.`id` = `users`.`unite_id`

        LEFT JOIN `transformation_fonctions` 
        ON `transformation_fonctions`.`id` = `transformation_user_fonction`.`fonction_id` 
        
        LEFT JOIN `transformation_compagnonage_fonction` 
        ON `transformation_compagnonage_fonction`.`fonction_id` = `transformation_fonctions`.`id` 
        
        LEFT JOIN `transformation_compagnonages` 
        ON `transformation_compagnonages`.`id` = `transformation_compagnonage_fonction`.`compagnonage_id`
        
        LEFT JOIN `transformation_compagnonage_tache` 
        ON `transformation_compagnonages`.`id` = `transformation_compagnonage_tache`.`compagnonage_id`
        
        LEFT JOIN `transformation_taches` 
        ON `transformation_taches`.`id` = `transformation_compagnonage_tache`.`tache_id`
        
        LEFT JOIN `transformation_tache_objectif` 
        ON `transformation_taches`.`id` = `transformation_tache_objectif`.`tache_id`
        
        LEFT JOIN `transformation_objectifs`
        ON `transformation_objectifs`.`id` = `transformation_tache_objectif`.`objectif_id`
        
        LEFT JOIN `transformation_sous_objectifs` 
        ON `transformation_objectifs`.`id` = `transformation_sous_objectifs`.`objectif_id`
        
        LEFT JOIN `transformation_type_fonctions` 
        ON `transformation_fonctions`.`typefonction_id` = `transformation_type_fonctions`.`id`
        
        LEFT JOIN `transformation_user_sous_objectifs` 
        ON `transformation_user_sous_objectifs`.`sous_objectif_id` = `transformation_sous_objectifs`.`id` AND `transformation_user_sous_objectifs`.`user_id` = `users`.`id`
        
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS transformation_bilan_transformation");
    }
};
