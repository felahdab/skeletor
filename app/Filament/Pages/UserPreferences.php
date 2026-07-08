<?php

namespace App\Filament\Pages;

use App\Filament\PanelRegistry\ModuleDefinedPreferedPagesRegistry;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;

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
                    ->afterStateHydrated(function (Select $component) use ($record) {
                        $component->state($record['prefered_page']);
                    }),
                Action::make("changer_mon_mot_de_passe")
                    ->label("Modifier mon mot de passe")
                    ->requiresConfirmation()
                    ->visible(fn() => auth()->check())
                    ->schema([
                        TextInput::make('password')
                            ->label("Nouveau mot de passe")
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->label("Nouveau mot de passe pour confirmation")
                            ->required()
                            ->revealable()
                            ->password()
                            ->same('password'),
                        
                    ])
                    ->action(function($data){
                        if (! auth()->check()) 
                        { 
                            return; 
                        }
                        # Pour le principe, mais ne peut pas se produire car la page préférences n'est visible que quand l'utilisateur
                        # est connecté, et en plus l'action n'est elle aussi visible que quand l'utilisateur est connecté.
                        $user = auth()->user();
                        $user->password=$data['password'];
                        $user->save();
                    })
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
