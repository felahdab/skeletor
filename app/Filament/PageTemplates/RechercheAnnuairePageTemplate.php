<?php

namespace App\Filament\PageTemplates;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Action;
use Illuminate\Support\HtmlString;

use App\Models\AnnuaireUser;

class RechercheAnnuairePageTemplate extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';
    
    protected static ?string $title = 'Recherche dans l\'annuaire';

    protected $listeners = [
        'table-force-refresh' => '$refresh'
    ];

    protected static string $view = 'filament.resources.annudef-user-resource.pages.recherche-annudef';

    public ?array $data;

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->columns(4)
            ->schema([
                TextInput::make('nom'),
                TextInput::make('prenom'),
                TextInput::make('email'),
                TextInput::make('unite'),
            ]);
    }

    public function submitAction()
    {
        return Action::make('submit-annudef-search')
        ->label('Rechercher')
        ->extraAttributes([
            'wire:click' => new HtmlString("submit()")
        ]);
    }

    public function submit()
    {
        $state = $this->form->getState();
        AnnuaireUser::setQuery($state);
        $this->dispatch('table-force-refresh');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnuaireUser::query())
            ->columns([
                TextColumn::make('nom')
                    ->sortable(),
                TextColumn::make('prenom')
                    ->sortable(),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('unite')
                    ->sortable(),
                TextColumn::make('nid')
                    ->sortable(),
                
            ])
            ->filters([
                // ...
            ])
            ->actions(
                $this->getRowActions()
            )
            ->bulkActions(
                $this->getBulkActions()
            );
    }

    public function getRowActions()
    {
        return [];
    }

    public function getBulkActions()
    {
        return [];
    }

}
