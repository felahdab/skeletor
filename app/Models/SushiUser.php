<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SushiUser extends Model
{
    use \Sushi\Sushi;
    
    public static $users=[];
    public static function setUsers($users)
    {
        self::$users=$users;
    }

    protected $schema = [
        'id'            => 'integer',
        'name'          => 'string',
        'email'         => 'string',
        'prenom'        => 'string',
        'matricule'     => 'string',
        'date_embarq'   => 'date',
        'date_debarq'   => 'date',
        'grade_id'      => 'integer',
        'specialite_id' => 'integer',
        'diplome_id'    => 'integer',
        'secteur_id'    => 'integer',
        'unite_id'      => 'integer',
        'grade'         => 'string',
        'specialite'    => 'string',
        'diplome'       => 'string',
        'secteur'       => 'string',
        'user_comment'  => 'string',
        'taux_de_transformation' => 'float',
        'display_name'  => 'string',
        'nid'           => 'string',
        'comete'        => 'boolean',
        'socle'         => 'boolean',
        'date_archivage' => 'date',
    ];

    protected function sushiShouldCache(){
        return false;
    }

    public function getRows()
    {
        return self::$users;
    }
    
}