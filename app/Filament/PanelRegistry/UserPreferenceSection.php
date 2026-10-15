<?php

namespace App\Filament\PanelRegistry;

use App\Models\User;
use Closure;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use InvalidArgumentException;

class UserPreferenceSection
{
    private string $label;

    private ?string $description = null;

    /**
     * @var array<\Filament\Schemas\Components\Component> | Closure
     */
    private array|Closure $schema = [];

    private bool|Closure $visible = true;

    final public function __construct(private readonly string $key)
    {
        if (! preg_match('/^[a-z][a-z0-9_]*$/', $key)) {
            throw new InvalidArgumentException(
                'User preference section keys must start with a lowercase letter and contain only lowercase letters, numbers, and underscores.'
            );
        }

        $this->label = Str::headline($key);
    }

    public static function make(string $key): static
    {
        return new static($key);
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param  array<\Filament\Schemas\Components\Component> | Closure  $schema
     */
    public function schema(array|Closure $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    public function visible(bool|Closure $visible): static
    {
        $this->visible = $visible;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function isVisible(User $user): bool
    {
        return (bool) value($this->visible, $user);
    }

    public function toFormComponent(): Section
    {
        return Section::make($this->label)
            ->description($this->description)
            ->schema($this->schema)
            ->statePath("module_preferences.{$this->key}");
    }
}
