<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::factory(3)->create();

        Tenant::all()->each(function ($tenant) {
            User::factory(20)->create([
                'tenant_id' => $tenant->id,
            ]);
        });

        User::all()->each(function ($user) {
            Login::factory(5)->create([
                'user_id' => $user->id,
                'tenant_id' => $user->tenant_id,
            ]);
        });

        User::factory()->create([
            'tenant_id' => null,
            'email' => 'admin@admin.com',
        ]);
    }
}
