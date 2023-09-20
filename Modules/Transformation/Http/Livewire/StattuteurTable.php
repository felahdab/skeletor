<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Entities\User;
use App\Models\Unite;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Secteur;
use App\Models\Service;

use Modules\Transformation\Entities\Fonction;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

use Modules\Transformation\Scopes\MemeUnite;

class StattuteurTable extends DataTableComponent
{
    //protected $model = User::class;

    public $service;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableRowUrl(function($row) {
            return route('transformation::transformation.livret', $row);
        });
        $this->setPaginationStatus(false);
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
        
        if ($this->service){
            $this->setFilter('service', $this->service->service_libcourt);
        }

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);

        $this->setTrAttributes(function($row) {
            if ($row->date_embarq >= date('Y-m-d')) {
              return ['style' => 'border-left: 10px solid purple !important'];
            }
            return [];
        });
    }

    public function builder(): Builder
    {
        $currentuser=auth()->user();
        $service_id=$currentuser->service->id;
        
        if ($currentuser->can('transformation::statistiques.statglobal')) {
            return User::query()
                      ->join ('secteurs', 'secteurs.id', '=', 'users.secteur_id')
                      ->WhereExists(function($maquery){
                          $maquery->select ('id')
                                    ->from ('transformation_user_fonction')
                                    ->whereColumn('transformation_user_fonction.user_id', 'users.id')
                      ;})
                     ;
        }
        else
        {
            return User::query()
                      ->join ('secteurs', 'secteurs.id', '=', 'users.secteur_id')
                      ->where('secteurs.service_id', $service_id)
                      ->WhereExists(function($maquery){
                          $maquery->select ('id')
                                    ->from ('transformation_user_fonction')
                                    ->whereColumn('transformation_user_fonction.user_id', 'users.id')
                      ;})
                     ;
        }
    }

    public function userActions()
    {
        return view('transformation::tables.stattable.boutons');
    }

    public function columns(): array
    {
        
        $basecolumns = [
            Column::make("Id", "id")
                ->deSelected()
                ->sortable(),
            Column::make('Grade', 'grade.grade_libcourt')
                ->searchable(),
            Column::make("Nom", "name")
                ->sortable()
                ->searchable(),
            Column::make("Prénom", "prenom")
                ->searchable(),
            Column::make('Brevet', 'diplome.diplome_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Specialite', 'specialite.specialite_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Groupement', 'secteur.service.groupement.groupement_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Service', 'secteur.service.service_libcourt')
                ->deSelected()
                ->searchable(),
            Column::make('Secteur', 'secteur.secteur_libcourt')
                ->searchable(),
            Column::make('Fonction à quai')
                ->label(
                    fn($row, Column $column) => view('transformation::tables.stattable.foncquai', ['marin' => $row])
                    )
                ->searchable(),
            Column::make('Fonction à la mer')
                ->label(
                    fn($row, Column $column) => view('transformation::tables.stattable.foncmer', ['marin' => $row])
                    )
                ->searchable(),
            Column::make('Fonction métier')
                ->label(
                    fn($row, Column $column) => view('transformation::tables.stattable.foncmetier', ['marin' => $row])
                    )
                ->searchable(),
            Column::make("Tx transfo", "taux_de_transformation")
                ->sortable()
                ->searchable(), 
            Column::make('Date Embarq', 'date_embarq')
                ->sortable()
                ->deSelected(),
            Column::make('Nb jours')
                ->sortable()
                ->label(
                    fn($row, Column $column) => $row->NbJoursPresence(),
                    ),
            Column::make(' ')
                ->label(
                    fn($row, Column $column) => view('transformation::tables.stattable.attentevalid', ['marin' => $row])
                    )
                ->searchable(),
            Column::make('U-actuelle', 'unite_id')
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => view('tables.userstable.libunite')->withRow($row))
                ->deSelected(),
            Column::make('U-dest', 'unite_destination.unite_libcourt')
                ->sortable()
                ->searchable()
                ->deSelected(),

                
            ];
        return array_merge($basecolumns , [
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->userActions()->withRow($row)
                    ),
        ]);
    }
    public function filters(): array
    {
        $currentuser=auth()->user();
        
        $filter = [
            TextFilter::make('Fonction')
                ->config([
                    'placeholder' => 'OCDQ...',
                    'maxlength'   => 50
                    ])
                ->filter(function(Builder $builder, string $value) {
                    $fonction_ids = Fonction::where('fonction_libcourt', 'like', '%' . $value . '%')
                                    ->orWhere('fonction_liblong', 'like', '%' . $value . '%')
                                    ->get()
                                    ->pluck('id');
                    $userids = DB::table('transformation_user_fonction')
                                ->whereIn('fonction_id', $fonction_ids)
                                ->get()
                                ->pluck('user_id');
                    if ($userids != null)
                        $builder->whereIn('users.id', $userids);
            }),
            TextFilter::make('U-actuelle')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 50
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $unite = Unite::where('unite_libcourt', 'like', '%' . $value . '%')
                                    ->orWhere('unite_liblong', 'like', '%' . $value . '%')
                                    ->get()->pluck('id');
                        if ($unite != null)
                            $builder->whereIn('unite_id', $unite);
                }),
            TextFilter::make('U-dest')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 10
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $unite = Unite::where('unite_libcourt', 'like', '%' . $value . '%')->get()->pluck('id');
                        if ($unite != null)
                            $builder->whereIn('unite_destination_id', $unite);
                }),
            TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'RESEAU...',
                    'maxlength'   => 50
                    ])
                ->filter(function(Builder $builder, string $value) {
                    $secteur = Secteur::where('secteur_libcourt', 'like', $value . '%')->get()->first();
                    if ($secteur != null)
                        $builder->where('secteur_id', $secteur->id);
                }),
            DateFilter::make('Date Embarq')
                ->filter(function(Builder $builder, string $value) {
                        $builder->where('date_embarq','<=', $value);
                }),
        ];
                
        if ($currentuser->hasRole("em")){
            $servicefilter = [ TextFilter::make('Service')
                ->config([
                    'placeholder' => 'SIC...',
                    'maxlength'   => 10
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $service = Service::where('service_libcourt', 'like', $value . '%')->get()->first();
                        if ($service != null)
                            $secteurs = $service->secteurs()->get()->pluck('id');
                            $builder->whereIn('secteur_id', $secteurs);
                })
                ];
                
            $filter = array_merge($filter, $servicefilter);
        }
        
        return $filter;
           
    }
}
