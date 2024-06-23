<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Login>
 */
class LoginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomDateTime = fake()->dateTimeBetween('-6 hours', 'now');
        return [
            'user_id' => User::factory()->create()->id,
            'tenant_id' => Tenant::factory()->create()->id,
            'created_at' => $randomDateTime,
            'updated_at' => $randomDateTime,
        ];
    }
}
