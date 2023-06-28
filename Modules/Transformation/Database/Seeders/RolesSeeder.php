<?php

namespace Modules\Transformation\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrCreate('user');
        $rolepermissions = [
            'transformation::transformation.mafichebilan',
            'transformation::transformation.monlivret',
            'transformation::transformation.maprogression',
        ];
        $role->givePermissionTo($rolepermissions);

        $role = Role::findOrCreate('tuteur');
        $rolepermissions = [
            'transformation::fonctions.choixmarins',
            'transformation::fonctions.validermarins',
            'transformation::stages.show',
            'transformation::transformation.index',
            'transformation::transformation.indexparfonction',
            'transformation::transformation.indexparstage',
            'transformation::transformation.livret',
            'transformation::transformation.livretpdf',
            'transformation::transformation.progression',
            'transformation::transformation.fichebilan',
            'transformation::statistiques.pourtuteurs',
            'transformation::transformation.updatelivret'
        ];
        $role->syncPermissions($rolepermissions);

        $role = Role::findOrCreate('em');
        $rolepermissions = [
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'transformation::stages.show',
            'transformation::transformation.index',
            'transformation::transformation.indexparfonction',
            'transformation::transformation.indexparstage',
            'transformation::users.choisirfonction',
            'transformation::users.attribuerfonction',
            'transformation::users.retirerfonction',
            'transformation::transformation.livret',
            'transformation::transformation.livretpdf',
            'transformation::transformation.progression',
            'transformation::transformation.fichebilan',
            'transformation::statistiques.pourem',
            'transformation::statistiques.index',
            'transformation::transformation.updatelivret'

        ];
        $role->syncPermissions($rolepermissions);

        $role = Role::findOrCreate('bord');
        $rolepermissions = [
            'transformation::transformation.index',
            'transformation::transformation.livret',
            'transformation::transformation.livretpdf',
            'transformation::transformation.progression',
            'transformation::transformation.fichebilan',
            'transformation::transformation.updatelivret'
        ];
        $role->syncPermissions($rolepermissions);

        $role = Role::findOrCreate('2ps');
        $rolepermissions = [
            'mindefconnect.index',
            'mindefconnect.edit',
            'mindefconnect.store',
            'mindefconnect.destroy',
            'users.index',
            'users.create',
            'users.store',
            'users.show',
            'users.edit',
            'users.update',
            'users.destroy',
            'transformation::sous-objectifs.index',
            'transformation::sous-objectifs.create',
            'transformation::sous-objectifs.store',
            'transformation::sous-objectifs.show',
            'transformation::sous-objectifs.edit',
            'transformation::sous-objectifs.update',
            'transformation::sous-objectifs.destroy',
            'transformation::sous-objectifs.multipleupdate',
            'transformation::objectifs.index',
            'transformation::objectifs.create',
            'transformation::objectifs.store',
            'transformation::objectifs.show',
            'transformation::objectifs.edit',
            'transformation::objectifs.update',
            'transformation::objectifs.destroy',
            'transformation::compagnonages.index',
            'transformation::compagnonages.create',
            'transformation::compagnonages.store',
            'transformation::compagnonages.show',
            'transformation::compagnonages.edit',
            'transformation::compagnonages.update',
            'transformation::compagnonages.destroy',
            'transformation::compagnonages.choisirtache',
            'transformation::compagnonages.ajoutertache',
            'transformation::compagnonages.removetache',
            'transformation::taches.index',
            'transformation::taches.create',
            'transformation::taches.store',
            'transformation::taches.show',
            'transformation::taches.edit',
            'transformation::taches.update',
            'transformation::taches.destroy',
            'transformation::taches.choisirobjectif',
            'transformation::taches.ajouterobjectif',
            'transformation::taches.removeobjectif',
            'transformation::fonctions.index',
            'transformation::fonctions.create',
            'transformation::fonctions.store',
            'transformation::fonctions.show',
            'transformation::fonctions.edit',
            'transformation::fonctions.update',
            'transformation::fonctions.destroy',
            'transformation::fonctions.choisircompagnonage',
            'transformation::fonctions.ajoutercompagnonage',
            'transformation::fonctions.removecompagnonage',
            'transformation::fonctions.choisirstage',
            'transformation::fonctions.ajouterstage',
            'transformation::fonctions.removestage',
            'transformation::fonctions.choixmarins',
            'transformation::fonctions.validermarins',
            'transformation::stages.index',
            'transformation::stages.create',
            'transformation::stages.store',
            'transformation::stages.show',
            'transformation::stages.edit',
            'transformation::stages.update',
            'transformation::stages.destroy',
            'transformation::stages.validermarins',
            'transformation::stages.attribuerstage',
            'transformation::stages.annulermarins',
            'transformation::transformation.index',
            'transformation::transformation.indexparfonction',
            'transformation::transformation.indexparstage',
            'transformation::users.choisirfonction',
            'transformation::users.attribuerfonction',
            'transformation::users.retirerfonction',
            'transformation::transformation.livret',
            'transformation::transformation.livretpdf',
            'transformation::transformation.progression',
            'transformation::transformation.fichebilan',
            'transformation::statistiques.index',
            'transformation::statistiques.pourtuteurs',
            'transformation::statistiques.pourem',
            'transformation::statistiques.pour2ps',
            'transformation::transformation.updatelivret'
        ];
        $role->syncPermissions($rolepermissions);

        $role = Role::findOrCreate('visiteur');
        $rolepermissions = [
            'transformation::fonctions.listemarinsfonction',
            'transformation::transformation.exportparcours',
            'transformation::transformation.fichebilan',
            'transformation::transformation.index',
            'transformation::transformation.livret'
        ];
        $role->syncPermissions($rolepermissions);
    }
}
