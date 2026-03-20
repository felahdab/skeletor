<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BugReport>
 */
class BugReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::all()->first();

        return [
            'message' => 'test message',
            'user_id' => $user->id,
            'url' => 'https://app.url.tld/',
        ];
    }
}
