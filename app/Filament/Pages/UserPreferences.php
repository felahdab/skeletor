<?php

namespace App\Filament\Pages;

use App\Filament\PanelRegistry\ModuleDefinedUserPreferencesRegistry;
use App\Filament\PanelRegistry\UserPreferenceSection;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password as PasswordValidator;

class UserPreferences extends EditProfile
{
    protected string|Width|null $maxWidth = Width::FourExtraLarge->value;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ...array_values(
                    array_map(
                        fn (UserPreferenceSection $section) => $section->toFormComponent(),
                        $this->getVisibleUserPreferenceSections(),
                    ),
                ),
                Action::make('changer_mon_mot_de_passe')
                    ->label('Modifier mon mot de passe')
                    ->requiresConfirmation()
                    ->visible(fn () => auth()->check())
                    ->schema([
                        TextInput::make('password')
                            ->label("Nouveau mot de passe")
                            ->password()
                            ->revealable()
                            ->minLength(12)
                            ->required()
                            ->confirmed()
                            ->rules(['required', 'confirmed', PasswordValidator::min(12)
                                                            ->letters()
                                                            ->mixedCase()
                                                            ->numbers()
                                                            ->symbols()]),
                        TextInput::make('password_confirmation')
                            ->label("Nouveau mot de passe pour confirmation")
                            ->required()
                            ->revealable()
                            ->password()
                            ->same('password'),
                    ])
                    ->action(function ($data) {
                        if (! auth()->check()) {
                            return;
                        }

                        # Pour le principe, mais ne peut pas se produire car la page préférences
                        # n'est visible que quand l'utilisateur est connecté, et en plus l'action
                        # n'est elle aussi visible que quand l'utilisateur est connecté.
                        $user = auth()->user();
                        $user->password = $data['password'];
                        $user->save();
                    }),
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var User $user */
        $user = $this->getUser();

        foreach ($this->getVisibleUserPreferenceSections() as $section) {
            Arr::set(
                $data,
                "module_preferences.{$section->getKey()}",
                $user->getPreferences($section->getKey()),
            );
        }

        return $data;
    }

    public function save(): void
    {
        /** @var User $user */
        $user = auth()->user();
        $state = $this->form->getState();

        foreach ($this->getVisibleUserPreferenceSections() as $section) {
            $key = $section->getKey();
            $submittedPreferences = Arr::get($state, "module_preferences.{$key}", []);

            if (! is_array($submittedPreferences)) {
                throw new \UnexpectedValueException(
                    "The submitted user preferences for section [{$key}] must be an array."
                );
            }

            $user->setPreferences($key, $submittedPreferences);
        }

        $user->save();
    }

    /**
     * @return array<string, UserPreferenceSection>
     */
    private function getVisibleUserPreferenceSections(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return app(ModuleDefinedUserPreferencesRegistry::class)
            ->getVisibleUserPreferenceSections($user);
    }

    public static function getLabel(): string
    {
        return 'Mes préférences';
    }
}
