<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Déplace la préférence utilisateur "prefered_page" vers la section "skeletor",
     * désormais déclarée via le ModuleDefinedUserPreferencesRegistry.
     */
    public function up(): void
    {
        $this->movePreference('settings.prefered_page', 'settings.skeletor.prefered_page');
    }

    public function down(): void
    {
        $this->movePreference('settings.skeletor.prefered_page', 'settings.prefered_page');
    }

    private function movePreference(string $from, string $to): void
    {
        DB::table('users')
            ->select('id', 'data')
            ->orderBy('id')
            ->chunk(200, function ($users) use ($from, $to) {
                foreach ($users as $user) {
                    $data = json_decode($user->data ?? '', true);

                    if (!is_array($data) || !Arr::has($data, $from)) {
                        continue;
                    }

                    $value = Arr::get($data, $from);
                    $this->forget($data, $from);
                    Arr::set($data, $to, $value);

                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['data' => json_encode($data)]);
                }
            });
    }

    /**
     * Retire une clé ainsi que les tableaux parents devenus vides, afin de ne pas
     * laisser de sections de préférences vides dans le JSON de l'utilisateur.
     */
    private function forget(array &$data, string $path): void
    {
        Arr::forget($data, $path);

        $segments = explode('.', $path);
        array_pop($segments);

        while ([] !== $segments) {
            $parent = implode('.', $segments);

            if ([] !== Arr::get($data, $parent)) {
                break;
            }

            Arr::forget($data, $parent);
            array_pop($segments);
        }
    }
};
