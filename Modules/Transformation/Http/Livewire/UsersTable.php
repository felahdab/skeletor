<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Entities\User;
use App\Models\Unite;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Specialite;
use App\Models\Secteur;
use App\Models\Service;
use App\Models\Groupement;
use Spatie\Permission\Models\Role;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Barryvdh\Debugbar\Facades\Debugbar;

use Modules\Transformation\Scopes\MemeUnite;

class UsersTable extends DataTableComponent
{
    // protected $model = User::class;

    public function builder(): Builder
    {
        switch ($this->mode) {
            case "listmarin":
                $userlist = User::query()->join('transformation_user_fonction', 'users.id', '=', 'user_id')->Where('fonction_id', $this->fonction->id)->get()->pluck('user_id', 'id');
                return User::query()->whereIn('users.id', $userlist);
                break;
            case "dashboard":
                $userlist = DB::table('transformation_user_fonction')->get()->pluck('user_id')->unique();
                return User::query()->whereIn('users.id', $userlist)->withTrashed()->where('users.date_embarq', '<=', date("Y-m-d"));
                break;
            case "archiv":
                $userlist = User::query()->withTrashed()
                    ->whereNotNull('users.deleted_at');  // qui ont ete supprime depuis la liste des utilisateurs
                return $userlist;
                break;
            default:
                return User::query();
                break;
        }
    }

    public $mode = 'gestion';
    public $fonction = null;
    public $userids = null;

    public function configure(): void
    {
        $this->setPrimaryKey('users.id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);

        $this->setAdditionalSelects(['users.date_debarq as date_debarq','users.date_embarq as date_embarq']);
        $this->setTrAttributes(function($row) {
            if ($row->date_embarq >= date('Y-m-d')) {
                return ['style' => 'border-left: 10px solid purple !important'];
            } elseif ($row->date_debarq != null && $this->mode == 'dashboard') {
                return ['style' => 'border-left: 10px solid deepskyblue !important'];
            }
            return [];
        });
    }

    public function userActions()
    {
        switch ($this->mode) {
            case "gestion":
                return view('transformation::tables.userstable.gestion');
                break;
            case "transformation":
                return view('transformation::tables.userstable.transformation');
                break;
            case "archiv":
                return view('transformation::tables.userstable.archivage');
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
            Column::make('U-dest', 'unite_destination.unite_libcourt')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Comete', 'comete')
                ->deSelected()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('transformation::tables.userstable.comete')->withRow($row)
                ),
            Column::make('Socle', 'socle')
                ->deSelected()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('transformation::tables.userstable.socle')->withRow($row)
                ),
        ];
        switch ($this->mode) {
            case "dashboard":
                return array_merge($basecolumns, [
                    Column::make('Taux de transformation', 'taux_de_transformation')
                        ->view('transformation::tables.userstable.tx_transfo')
                        ->sortable(),
                    Column::make('Rôles')
                        ->label(
                            fn ($row, Column $column) => view('transformation::tables.userstable.roles')->withRow($row)
                        ),
                ]);
                break;
            case "gestion":
                return array_merge($basecolumns, [
                    Column::make('Rôles')
                        ->label(
                            fn ($row, Column $column) => view('transformation::tables.userstable.roles')->withRow($row)
                        ),
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
                break;
            case "transformation":
                return array_merge($basecolumns, [
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
                break;
            case "listmarin":
                return array_merge($basecolumns, [
                    Column::make('Tx transfo')
                        ->label(
                            fn ($row, Column $column) => $row->pourcentage_valides_pour_fonction($this->fonction, true)
                        ),
                    // ne fonctionne pas avec false car renvoie null. ???????
                    Column::make('Laché')
                        ->label(
                            fn ($row, Column $column) => $row->fonctions()->find($this->fonction)->pivot->date_lache
                        ),
                    Column::make('Nb jours')
                        ->label(
                            fn ($row, Column $column) => $row->fonctions()->find($this->fonction)->pivot->nb_jours_pour_validation
                        ),
                    Column::make('Date Embarq', 'date_embarq')
                        ->sortable(),
                ]);
                break;
            case "archiv":
                return array_merge($basecolumns, [
                    Column::make('Supprimé', 'deleted_at')
                        ->deSelected(),
                    Column::make('Débarq.', 'date_debarq')
                        ->searchable(),
                    Column::make("Date d'archivage", 'date_archivage')
                        ->searchable()
                        ->deselected(),
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
            case "selection":
                return array_merge($basecolumns, [
                    Column::make('Actions')
                        ->label(
                            fn ($row, Column $column) => $this->userActions()->withRow($row)
                        ),
                ]);
                break;
            default:
                return $basecolumns;
                break;
        }
    }

    public function filters(): array
    {
        $basefilters = [
            TextFilter::make('Grade')
                ->config([
                    'placeholder' => 'SM...',
                    'maxlength'   => 3
                ])
                ->filter(function (Builder $builder, string $value) {
                    $grade = Grade::where('grade_libcourt', 'like', $value . '%')->get()->first();
                    if ($grade != null)
                        $builder->where('grade_id', $grade->id);
                }),
            TextFilter::make('Brevet')
                ->config([
                    'placeholder' => 'BAT...',
                    'maxlength'   => 50
                ])
                ->filter(function (Builder $builder, string $value) {
                    $diplome = Diplome::where('diplome_libcourt', 'like', $value . '%')->get()->first();
                    if ($diplome != null)
                        $builder->where('diplome_id', $diplome->id);
                }),
            TextFilter::make('Spé')
                ->config([
                    'placeholder' => 'SECNAV...',
                    'maxlength'   => 15
                ])
                ->filter(function (Builder $builder, string $value) {
                    $specialite = Specialite::where('specialite_libcourt', 'like', $value . '%')->get()->first();
                    if ($specialite != null)
                        $builder->where('specialite_id', $specialite->id);
                }),
            TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'DEM...',
                    'maxlength'   => 50
                ])
                ->filter(function (Builder $builder, string $value) {
                    $secteur = Secteur::where('secteur_libcourt', 'like', $value . '%')->get()->first();
                    if ($secteur != null)
                        $builder->where('secteur_id', $secteur->id);
                }),
            TextFilter::make('Service')
                ->config([
                    'placeholder' => 'LAS...',
                    'maxlength'   => 5
                ])
                ->filter(function (Builder $builder, string $value) {
                    $service = Service::where('service_libcourt', 'like', $value . '%')->get()->first();
                    if ($service != null)
                        $builder->where('service_id', $service->id);
                }),
            TextFilter::make('Gpmt')
                ->config([
                    'placeholder' => 'NAV...',
                    'maxlength'   => 5
                ])
                ->filter(function (Builder $builder, string $value) {
                    $gpmt = Groupement::where('groupement_libcourt', 'like', $value . '%')->get()->first();
                    if ($gpmt != null)
                        $builder->where('groupement_id', $gpmt->id);
                }),
            TextFilter::make('U-dest')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 10
                ])
                ->filter(function (Builder $builder, string $value) {
                    $unite = Unite::where('unite_libcourt', 'like', '%' . $value . '%')->get()->pluck('id');
                    if ($unite != null)
                        $builder->whereIn('unite_destination_id', $unite);
                }),
            SelectFilter::make('Comete')
                ->options([
                    '' => 'Tous',
                    '1' => 'Embarqué',
                    '0' => 'Non embarqué',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('comete', true);
                    } elseif ($value === '0') {
                        $builder->where('comete', false);
                    }
                }),
            SelectFilter::make('Socle')
                ->options([
                    '' => 'Tous',
                    '1' => 'Socle',
                    '0' => 'Transformation',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('socle', true);
                    } elseif ($value === '0') {
                        $builder->where('socle', false);
                    }
                }),
            SelectFilter::make('Fonction')
                ->options(
                    ['' => 'Tous'] + DB::table('transformation_fonctions')
                        ->pluck('fonction_libcourt', 'id')
                        ->toArray()
                )
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->whereExists(function ($query) use ($value) {
                            $query->select(DB::raw(1))
                                ->from('transformation_user_fonction')
                                ->whereRaw('transformation_user_fonction.user_id = users.id')
                                ->where('transformation_user_fonction.fonction_id', $value);
                        });
                    }
                }),
            SelectFilter::make('Unité')
                ->options(
                    ['' => 'Tous'] + DB::table('unites')
                        ->pluck('unite_libcourt', 'id')
                        ->toArray()
                )
                ->filter(function (Builder $builder, string $value) {
                    if ($value !== '') {
                        $builder->where('unite_id', $value);
                    }
                }),
        ];

        switch ($this->mode) {
            case "gestion":
            case "listmarins":
            case "dashboard":
                $basefilters[] = MultiSelectFilter::make('Roles')
                    ->options(
                        Role::query()
                            ->orderBy('name')
                            ->get()
                            ->keyBy('id')
                            ->map(fn ($role) => $role->name)
                            ->toArray()
                    )
                    // ->setFirstOption('Tous') // Pour MultiSelectDropdownFilter
                    ->filter(function (Builder $builder, array $values) {
                        $roles = Role::whereIn('id',  $values)->get();
                        $builder->role($roles);
                    });
                break;
            case "dashboard":
                $basefilters[] = SelectFilter::make('Date débarquement')
                    ->options([
                        '' => 'Tous',
                        '1' => 'Connue',
                        '0' => 'Non connue',
                    ])
                    ->filter(function (Builder $builder, string $value) {
                        if ($value === '1') {
                            $builder->where('date_debarq', '<>', null);
                        } elseif ($value === '0') {
                            $builder->where('date_debarq', null);
                        }
                    });

                break;
        }

        return $basefilters;
    }

    public function render(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->userids = $this->getCurrentItems();
        $this->dispatch("userListUpdated", $this->userids);
        return parent::render();
    }

    public function getCurrentItems()
    {
        return (clone $this->baseQuery())->pluck($this->getPrimaryKey())->map(fn ($item) => (string)$item)->toArray();
    }
}
