<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Entities\User;
use App\Models\SushiUser;

use App\Models\Unite;
use App\Models\Grade;
use App\Models\Diplome;
use App\Models\Specialite;
use App\Models\Secteur;
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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Barryvdh\Debugbar\Facades\Debugbar;

use Modules\Transformation\Scopes\MemeUnite;

class SushiUsersTable extends DataTableComponent
{
    public $mode = 'gestion';
    public $fonction = null;

    public $userids = null;
    private $userlist = null;
    public $baseusers = [];

    public array $perPageAccepted = [10, 25, 50, 100];

    public function mount()
    {
        $relevant_userids = DB::table('transformation_user_fonction')
            ->select('user_id')
            ->where('fonction_id', $this->fonction->id)
            ->get()
            ->pluck('user_id')
            ->all();

        $this->userlist = User::query()
            ->whereIn('id', $relevant_userids)
            ->with('secteur.service.groupement')
            ->with('grade')
            ->with('specialite')
            ->with('diplome')
            ->with('fonctions')
            ->with('unite_destination')
            ->get();

        $fonction = $this->fonction;
        $this->baseusers = $this->userlist
            ->map(function ($user) {
                $user->diplomelibcourt = $user->diplome?->diplome_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->gradelibcourt = $user->grade?->grade_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->secteurlibcourt = $user->secteur?->secteur_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->servicelibcourt = $user->secteur?->service->service_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->groupementlibcourt = $user->secteur?->service->groupement->groupement_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->specialitelibcourt = $user->specialite?->specialite_libcourt;
                return $user;
            })
            ->map(function ($user) {
                $user->unitedestinationlibcourt = $user->unite_destination?->unite_libcourt;
                return $user;
            })
            ->map(
                function ($user) use ($fonction) {
                    $w = $user->fonctions->where('id', $fonction->id)->first()->pivot;
                    $user->taux_de_transformation_fonction = $w?->taux_de_transformation;
                    $user->nb_jours_pour_validation_fonction = $w?->nb_jours_pour_validation;
                    $user->lache_dans_fonction = $w?->date_lache ? true : false;
                    return $user;
                }
            )

            ->map(
                function ($user) {
                    unset($user["grade"]);
                    unset($user["secteur"]);
                    unset($user["specialite"]);
                    unset($user["diplome"]);
                    unset($user["fonctions"]);
                    unset($user["unite_destination"]);
                    return $user;
                }
            )
            ->map(function ($user) {
                return $user->toArray();
            })
            ->all();
    }

    public function builder(): Builder
    {
        switch ($this->mode) {
            case "listmarin":
                // dd($this->baseusers);
                SushiUser::setUsers($this->baseusers);
                return SushiUser::query();
                break;
            default:
                return SushiUser::query();
                break;
        }
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('name', 'asc');
        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);
    }

    public function userActions()
    {
        switch ($this->mode) {
            case "listmarin":
                return view('transformation::tables.userstable.listmarins');
                break;
        }
    }

    public function columns(): array
    {
        $basecolumns = [
            Column::make('Grade', 'gradelibcourt')
                ->searchable()
                ->sortable(),
            Column::make('Brevet', 'diplomelibcourt')
                ->searchable()
                ->sortable(),
            Column::make('Spécialité', 'specialitelibcourt')
                ->searchable()
                ->sortable(),
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
            Column::make('Secteur', 'secteurlibcourt')
                ->searchable()
                ->sortable(),
            Column::make('Service', 'servicelibcourt')
                ->searchable()
                ->sortable(),
            Column::make('Groupement', 'groupementlibcourt')
                ->searchable()
                ->sortable(),
            Column::make('U-dest', 'unitedestinationlibcourt')
                ->sortable()
                ->searchable()
                ->deSelected(),
            Column::make('Comete', 'comete')
                ->deSelected()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('tables.userstable.comete')->withRow($row)
                ),
            Column::make('Socle', 'socle')
                ->deSelected()
                ->searchable()
                ->format(
                    fn ($value, $row, Column $column) => view('tables.userstable.socle')->withRow($row)
                ),
        ];

        switch ($this->mode) {
            case "listmarin":
                return array_merge($basecolumns, [
                    Column::make('Tx transfo', 'taux_de_transformation_fonction')
                        ->view('tables.userstable.tx_transfo_fonction')
                        ->sortable(),
                    Column::make('Laché', 'lache_dans_fonction')
                        ->format(
                            fn ($value, $row, Column $column) => view('tables.userstable.lache')->withRow($row)
                        ),
                    Column::make('Nb jours', 'nb_jours_pour_validation_fonction')
                        ->sortable(),
                    Column::make('Date Embarq', 'date_embarq')
                        ->sortable(),
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
                    $grade = Grade::where('grade_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($grade != null)
                        $builder->where('grade_id', $grade->id);
                }),
            TextFilter::make('Brevet')
                ->config([
                    'placeholder' => 'BAT...',
                    'maxlength'   => 3
                ])
                ->filter(function (Builder $builder, string $value) {
                    $diplome = Diplome::where('diplome_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($diplome != null)
                        $builder->where('diplome_id', $diplome->id);
                }),
            TextFilter::make('Spé')
                ->config([
                    'placeholder' => 'SECNAV...',
                    'maxlength'   => 15
                ])
                ->filter(function (Builder $builder, string $value) {
                    $specialite = Specialite::where('specialite_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($specialite != null)
                        $builder->where('specialite_id', $specialite->id);
                }),
            TextFilter::make('Secteur')
                ->config([
                    'placeholder' => 'DEM...',
                    'maxlength'   => 5
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
                    $service = Service::where('service_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($service != null)
                        $builder->where('servicelibcourt', $service->service_libcourt);
                }),
            TextFilter::make('Gpmt')
                ->config([
                    'placeholder' => 'NAV...',
                    'maxlength'   => 5
                ])
                ->filter(function (Builder $builder, string $value) {
                    $gpmt = Groupement::where('groupement_libcourt', 'like', '%' . $value . '%')->get()->first();
                    if ($gpmt != null)
                        $builder->where('groupementlibcourt', $gpmt->groupement_libcourt);
                }),
            TextFilter::make('U-dest')
                ->config([
                    'placeholder' => 'LGC...',
                    'maxlength'   => 5
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
            SelectFilter::make('Lâché')
                ->options([
                    '' => 'Tous',
                    '1' => 'Lâché',
                    '0' => 'Non lâché',
                ])
                ->filter(function (Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('lache_dans_fonction', true);
                    } elseif ($value === '0') {
                        $builder->where('lache_dans_fonction', false);
                    }
                }),
        ];

        return $basefilters;
    }

    // public function render()
    // {
    //     $this->userids = $this->getCurrentItems();
    //     $this->dispatch("userListUpdated", $this->userids);
    //     return parent::render();
    // }

    // public function getCurrentItems()
    // {
    //     return (clone $this->baseQuery())->pluck($this->getPrimaryKey())->map(fn ($item) => (string)$item)->toArray();
    // }
}
