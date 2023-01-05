<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Specialite;
use App\Models\Service;
use App\Models\Groupement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class UsersTable extends DataTableComponent
{
    // protected $model = User::class;
    
    public function builder(): Builder
    {
        switch ($this->mode){
            case "listmarin" :
                $userlist = User::query()->join('user_fonction','users.id','=','user_id')->Where('fonction_id', $this->fonction->id)->get()->pluck('user_id', 'id');
                return User::query()->whereIn('users.id', $userlist);
                break;
            case "archiv" :
                $today=date('d/m/Y');
                return User::withTrashed()->whereNotNull('users.date_debarq')->whereNull('users.date_archivage');
                break;
            default :
                return User::query();
                break;
        }
    }
    
    public $mode='gestion';
    public $fonction = null;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
    }

    public function userActions()
    {
        switch ($this->mode){
            case "gestion" :
                return view('tables.userstable.gestion');
                break;
            case "transformation" :
                return view('tables.userstable.transformation');
                break;
            case "archiv" :
                return view('tables.userstable.archivage');
                break;
        }
    }

    public function columns(): array
    {
        $basecolumns = [
            Column::make('Grade', 'grade.grade_libcourt')
                ->searchable(),
            Column::make('Brevet', 'diplome.diplome_libcourt')
                ->searchable(),
            Column::make('Spécialité', 'specialite.specialite_libcourt')
                ->searchable(),
            Column::make('ID', 'id')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Nom', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Prénom', 'prenom')
                ->sortable()
                ->searchable(),
            Column::make('Matricule', 'matricule')
                ->deSelected()
                ->searchable(),
            Column::make('NID', 'nid')
                ->deSelected()
                ->searchable(),
            Column::make('E-mail', 'email')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Secteur', 'secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Service', 'secteur.service.service_libcourt')
                ->searchable(),
            Column::make('Groupement', 'secteur.service.groupement.groupement_libcourt')
                ->searchable(),
            Column::make('Comete', 'comete')
                ->deSelected()
                ->searchable()
                ->format(
                    fn($value, $row, Column $column) => view('tables.userstable.comete')->withRow($row)),
            Column::make('Socle', 'socle')
                ->deSelected()
                ->searchable() 
                ->format(
                    fn($value, $row, Column $column) => view('tables.userstable.socle')->withRow($row)),
        ];
        switch ($this->mode){
            case "gestion" :
                return array_merge($basecolumns ,[
                    Column::make('Rôles')
                        ->label(
                            fn($row, Column $column) => view('tables.userstable.roles')->withRow($row)
                            ),
                    Column::make('Actions')
                        ->label(
                            fn($row, Column $column) => $this->userActions()->withRow($row)
                            ),
                ]);
                break;
            case "transformation" :
                return array_merge($basecolumns , [
                    Column::make('Actions')
                        ->label(
                            fn($row, Column $column) => $this->userActions()->withRow($row)
                            ),
                ]);
                break;
            case "listmarin" :
                return array_merge($basecolumns , [
                    Column::make('Tx transfo')
                        ->label(
                            fn($row, Column $column) => $row->pourcentage_valides_pour_fonction($this->fonction, true)),
                // ne fonctionne pas avec false car renvoie null. ???????
                    Column::make('Laché')
                        ->label(
                            fn($row, Column $column) => $row->fonctions()->find($this->fonction)->pivot->date_lache ),
                ]);
                break;
            case "archiv" :
                return array_merge($basecolumns , [
                    Column::make('Débarq.', 'date_debarq')
                        ->searchable(),
                    Column::make('Actions')
                        ->label(
                            fn($row, Column $column) => $this->userActions()->withRow($row)
                            ),
                ]);
                break;
            default :
                return $basecolumns;
                break;
        }
   }
    
    public function filters(): array
    {
        $basefilters= [
             TextFilter::make('Grade')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $grade = Grade::where('grade_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($grade != null)
                            $builder->where('grade_id', $grade->id);
                }),
            TextFilter::make('Brevet')
                ->config([
                    'placeholder' => 'BAT...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $diplome = Diplome::where('diplome_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($diplome != null)
                            $builder->where('diplome_id', $diplome->id);
                }),
            TextFilter::make('Spé')
                ->config([
                    'placeholder' => 'SECNAV...',
                    'maxlength'   => 15
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $specialite = Specialite::where('specialite_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($specialite != null)
                            $builder->where('specialite_id', $specialite->id);
                }),
            TextFilter::make('Service')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $service = Service::where('service_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($service != null)
                            $builder->where('service_id', $service->id);
                }),
            TextFilter::make('Gpmt')
                ->config([
                    'placeholder' => 'NAV...',
                    'maxlength'   => 5
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $gpmt = Groupement::where('groupement_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($gpmt != null)
                            $builder->where('groupement_id', $gpmt->id);
                }),
            SelectFilter::make('Comete')
                ->options([
                    '' => 'Tous',
                    '1' => 'Embarqué',
                    '0' => 'Non embarqué',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('comete', true);
                    } 
                    elseif ($value === '0') {
                        $builder->where('comete', false);
                    }
                }),
            SelectFilter::make('Socle')
                ->options([
                    '' => 'Tous',
                    '1' => 'Socle',
                    '0' => 'Transformation',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('socle', true);
                    } 
                    elseif ($value === '0') {
                        $builder->where('socle', false);
                    }
                }),
        ];
        
        return $basefilters;
    }
}