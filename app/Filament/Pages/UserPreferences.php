<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile;
use Filament\Support\Enums\Width;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Arr;

use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;

class UserPreferences extends EditProfile
{
    protected Width | string | null $maxWidth = Width::FourExtraLarge->value;

    public function form(Schema $schema): Schema
    {
        $record = [
            'prefered_page' => Arr::get(auth()->user()->data, 'settings.prefered_page', null),
        ];

        return $schema
            ->components([
                Select::make('prefered_page')
                    ->label("Page préférée")
                    ->helperText("L'application vous emmenera automatiquement à cette page lorsque vous vous connecterez")
                    ->options(app(ModuleDefinedPreferedPagesRegistry::class)->getPreferedPagesItemsForSelect())
                    ->selectablePlaceholder(false)
                    ->afterStateHydrated(function (Select $component, ?string $state) use ($record) {
                        $component->state($record["prefered_page"]);
                    }),
            ]);
    }

    public function save(): void
    {
        $user = auth()->user();
        $data = $user->data;

        $state = $this->form->getState();

        Arr::set($data, 'settings.prefered_page', $state["prefered_page"]);
        $user->data = $data;
        $user->save();

    }

    public static function getLabel(): string
    {
        return "Mes préférences";
    }
}
