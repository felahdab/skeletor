<?php

namespace Modules\Transformation\Http\Livewire;

use Modules\Transformation\Services\GererTransformationService;

use Modules\Transformation\Entities\Stage;
use App\Models\User;
use Modules\Transformation\Entities\TypeLicence;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;

class StagesTable extends DataTableComponent
{
    protected $listeners = ['refreshUser' => '$refresh'];
    
    protected $model = Stage::class;
    
    public $mode='gestion';
    public $user=null;

    public function builder(): Builder
    {
        if ($this->mode == "uservalidation")
        {
            $stagelist = $this->user->stages()->get()->pluck('id', 'id');
            return Stage::query()->whereIn('transformation_stages.id', $stagelist);
        }
        elseif ($this->mode == "selectnewstage")
        {
            $stagelist = $this->user->stages()->get()->pluck('id', 'id');
            return Stage::query()->whereNotIn('transformation_stages.id', $stagelist);
        }
        return Stage::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setFilterLayoutSlideDown();
        $this->setDefaultSort('stage_libcourt', 'asc');
        $this->setPerPage(50);
        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);

    }

    public function stageActions()
    {
        switch ($this->mode){
            case "gestion" :
                return view('transformation::tables.stagestable.gestion');
                break;
            case "transformation" :
                return view('transformation::tables.stagestable.transformation');
                break;
            case "uservalidation" :
                return view('transformation::tables.stagestable.uservalidation', ['user' => $this->user]);
                break;
            case "selectnewstage" :
                return view('transformation::tables.stagestable.selectnewstage', ['user' => $this->user]);
                break;
        }
    }

    public function columns(): array
    {
        switch ($this->mode){
            case "transformation" :
            case "uservalidation" :
                return [
                    Column::make('ID', 'id')
                        ->deSelected()
                        ->sortable(),
                    Column::make('Libellé court', 'stage_libcourt')
                        ->sortable()
                        ->searchable(),
                    Column::make('Libellé long', 'stage_liblong')
                        ->deSelected()
                        ->sortable()
                        ->searchable(),
                    Column::make('Actions')
                        ->label(
                            fn($row, Column $column) => $this->stageActions()->withRow($row)
                            ),
                ];
                break;
            default :
                return [
                    Column::make('ID', 'id')
                        ->deSelected()
                        ->sortable(),
                    Column::make('Libellé court', 'stage_libcourt')
                        ->sortable()
                        ->searchable(),
                    Column::make('Libellé long', 'stage_liblong')
                        ->sortable()
                        ->searchable(),
                    Column::make('Licence', 'type_licence.typlicense_libcourt')
                        ->searchable(),
                    Column::make('Date fin', 'stage_date_fin_licence')
                        ->sortable()
                        ->searchable(),
                    Column::make('Capa max', 'stage_capamax')
                        ->deSelected(),
                    Column::make('Durée (j)', 'stage_duree')
                        ->deSelected(),
                    Column::make('Lieu', 'stage_lieu')
                        ->sortable()
                        ->searchable(),
                    Column::make('Lien', 'stage_lienurl')
                        ->sortable()
                        ->deSelected()
                        ->searchable(),
                    Column::make('Commentaire', 'stage_commentaire')
                        ->deSelected()
                        ->searchable(),
                    Column::make('Actions')
                        ->label(
                            fn($row, Column $column) => $this->stageActions()->withRow($row)
                            ),
                ];
                break;
        }
    }
    
    public function filters(): array
    {
        return [
             TextFilter::make('Licence')
                ->config([
                    'placeholder' => '1...',
                    'maxlength'   => 3
                    ])
                ->filter(function(Builder $builder, string $value) {
                        $typelic = TypeLicence::where('typlicense_libcourt', 'like', '%' . $value . '%')->get()->first();
                        if ($typelic != null)
                            $builder->where('typelicence_id', $typelic->id);
                }),
        ];
    }
    
    public function UnvalidateStage(User $user, Stage $stage)
    {
        $transformationService = new GererTransformationService;
        $transformationService->unValidateStage($user, $stage);
    }
    
    public function ValidateStage(User $user, Stage $stage, $commentaire, $date_validation)
    {
        $transformationService = new GererTransformationService;
        $transformationService->validateStage($user, $stage, $commentaire, $date_validation);
    }
    
    public function ValidateCommentStage(User $user, Stage $stage, $commentaire)
    {
        $transformationService = new GererTransformationService;
        $transformationService->validateCommentStage($user, $stage, $commentaire);
    }
    
    public function AttribuerStage(User $user, Stage $stage)
    {
        $transformationService = new GererTransformationService;
        $transformationService->attachStage($user, $stage);
        $this->emit('refreshUser');
    }
    
    public function RetirerStage(User $user, Stage $stage)
    {
        $transformationService = new GererTransformationService;
        $transformationService->detachStage($user, $stage);
        $this->emit('refreshUser');
    }
}