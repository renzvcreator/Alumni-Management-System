<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Ensure every generated user has a matching profile, like real registrations.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if (! $user->profile) {
                Profile::create([
                    'user_id' => $user->id,
                    'first_name' => 'Test',
                    'last_name' => 'User',
                ]);
            }
        });
    }

    /**
     * An approved alumni account (can access member features).
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'alumni',
            'status' => 'approved',
        ]);
    }

    /**
     * An administrator account.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
