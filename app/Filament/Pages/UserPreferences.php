<?php

namespace App\Filament\Pages;

use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Arr;

class UserPreferences extends EditProfile
{
    protected string|Width|null $maxWidth = Width::FourExtraLarge->value;

    public function form(Schema $schema): Schema
    {
        $record = [
            'prefered_page' => Arr::get(auth()->user()->data, 'settings.prefered_page', null),
        ];

        return $schema
            ->components([
                Select::make('prefered_page')
                    ->label('Page préférée')
                    ->helperText("L'application vous emmenera automatiquement à cette page lorsque vous vous connecterez")
                    ->options(app(ModuleDefinedPreferedPagesRegistry::class)->getPreferedPagesItemsForSelect())
                    ->selectablePlaceholder(false)
                    ->afterStateHydrated(function (Select $component, ?string $state) use ($record) {
                        $component->state($record['prefered_page']);
                    }),
            ])
        ;
    }

    public function save(): void
    {
        $user = auth()->user();
        $data = $user->data;

        $state = $this->form->getState();

        Arr::set($data, 'settings.prefered_page', $state['prefered_page']);
        $user->data = $data;
        $user->save();
    }

    public static function getLabel(): string
    {
        return 'Mes préférences';
    }
}
