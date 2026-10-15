<?php

namespace App\Filament\PanelRegistry;

use App\Models\User;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class ModuleDefinedUserPreferencesRegistry
{
    /**
     * @var array<string, UserPreferenceSection>
     */
    private array $sections = [];

    public function registerUserPreferenceSections(array|UserPreferenceSection $sections): void
    {
        foreach (Arr::wrap($sections) as $section) {
            if (! $section instanceof UserPreferenceSection) {
                throw new InvalidArgumentException('User preference sections must be instances of UserPreferenceSection.');
            }

            if (array_key_exists($section->getKey(), $this->sections)) {
                throw new InvalidArgumentException(
                    "A user preference section with the key [{$section->getKey()}] is already registered."
                );
            }

            $this->sections[$section->getKey()] = $section;
        }
    }

    /**
     * @return array<string, UserPreferenceSection>
     */
    public function getUserPreferenceSections(): array
    {
        return $this->sections;
    }

    /**
     * @return array<string, UserPreferenceSection>
     */
    public function getVisibleUserPreferenceSections(User $user): array
    {
        return array_filter(
            $this->sections,
            fn (UserPreferenceSection $section): bool => $section->isVisible($user),
        );
    }
}
