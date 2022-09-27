<?php

namespace Database\Seeders;

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
        $role = Role::findOrCreate('admin');
        $rolepermissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($rolepermissions);

        // All users should be assigned the user role, which includes the basic permissions to login, logout, change your
        // own password and your current role.
        $role = Role::findOrCreate('user');
        $rolepermissions = [
            'logout.perform',
            'currentrole.show',
            'currentrole.store',
            'changepasswd.show',
            'changepasswd.store',
            'transformation.mafichebilan',
            'transformation.monlivret',
            'transformation.maprogression',
            'bugreports.store',
        ];
        $role->syncPermissions($rolepermissions);
        
        $role = Role::findOrCreate('tuteur');
        $rolepermissions = [
                'fonctions.choixmarins',
                'fonctions.validermarins',
                'stages.consulter',
                'stages.show',
                'transformation.index',
                'transformation.indexparfonction',
                'transformation.indexparstage',
                'transformation.livret',
                'transformation.livretpdf',
                'transformation.validerlacheoudouble',
                'transformation.progression',
                'transformation.fichebilan',
                'statistiques.pourtuteurs'];
        $role->syncPermissions($rolepermissions);
        
        $role = Role::findOrCreate('em');
        $rolepermissions = [
                'users.index',
                'users.create',
                'users.store',
                'users.show',
                'users.edit',
                'users.update',
                'stages.consulter',
                'stages.show',
                'transformation.index',
                'transformation.indexparfonction',
                'transformation.indexparstage',
                'users.choisirfonction',
                'users.attribuerfonction',
                'users.retirerfonction',
                'transformation.livret',
                'transformation.livretpdf',
                'transformation.validerlacheoudouble',
                'transformation.progression',
                'transformation.fichebilan',
                'statistiques.pourem',
                'statistiques.index',

        ];
        $role->syncPermissions($rolepermissions);
        
        $role = Role::findOrCreate( 'bord');
        $rolepermissions = [
            'transformation.index',
            'transformation.livret',
            'transformation.livretpdf',
            'transformation.validerlacheoudouble',
            'transformation.progression',
            'transformation.fichebilan',
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
            'sous-objectifs.index',
            'sous-objectifs.create',
            'sous-objectifs.store',
            'sous-objectifs.show',
            'sous-objectifs.edit',
            'sous-objectifs.update',
            'sous-objectifs.destroy',
            'sous-objectifs.multipleupdate',
            'objectifs.index',
            'objectifs.create',
            'objectifs.store',
            'objectifs.show',
            'objectifs.edit',
            'objectifs.update',
            'objectifs.destroy',
            'compagnonages.index',
            'compagnonages.create',
            'compagnonages.store',
            'compagnonages.show',
            'compagnonages.edit',
            'compagnonages.update',
            'compagnonages.destroy',
            'compagnonages.choisirtache',
            'compagnonages.ajoutertache',
            'compagnonages.removetache',
            'taches.index',
            'taches.create',
            'taches.store',
            'taches.show',
            'taches.edit',
            'taches.update',
            'taches.destroy',
            'taches.choisirobjectif',
            'taches.ajouterobjectif',
            'taches.removeobjectif',
            'fonctions.index',
            'fonctions.create',
            'fonctions.store',
            'fonctions.show',
            'fonctions.edit',
            'fonctions.update',
            'fonctions.destroy',
            'fonctions.choisircompagnonage',
            'fonctions.ajoutercompagnonage',
            'fonctions.removecompagnonage',
            'fonctions.choisirstage',
            'fonctions.ajouterstage',
            'fonctions.removestage',
            'fonctions.choixmarins',
            'fonctions.validermarins',
            'stages.consulter',
            'stages.index',
            'stages.create',
            'stages.store',
            'stages.show',
            'stages.edit',
            'stages.update',
            'stages.destroy',
            'stages.choixmarins',
            'stages.validermarins',
            'stages.attribuerstage',
            'stages.annulermarins',
            'transformation.index',
            'transformation.indexparfonction',
            'transformation.indexparstage',
            'users.choisirfonction',
            'users.attribuerfonction',
            'users.retirerfonction',
            'transformation.livret',
            'transformation.livretpdf',
            'transformation.validerlacheoudouble',
            'transformation.progression',
            'transformation.fichebilan',
            'statistiques.index',
            'statistiques.pourtuteurs',
            'statistiques.pourem',
            'statistiques.pour2ps',
        ];
        $role->syncPermissions($rolepermissions);
    }
}
