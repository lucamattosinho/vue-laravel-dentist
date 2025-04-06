<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PacienteSeeder::class,
            ConsultaSeeder::class,
            // Add other seeders here
        ]);
        

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password'=> Hash::make('admin123'),
        ]);
    }
}
