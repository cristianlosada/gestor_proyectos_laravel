<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(2)->create();
        \App\Models\Proyecto::factory(15)->create();
        \App\Models\Tarea::factory(30)->create();
        // // Crear roles
        \App\Models\Role::create(['name' => 'Administrador']);
        \App\Models\Role::create(['name' => 'Usuario']);

        // // Asignar roles a usuarios

        // Crear usuario administrador
        $admin = \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Crear usuario común
        $user = \App\Models\User::create([
            'name' => 'Cristian Lozada',
            'email' => 'cristianlosano314@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // \App\Models\User::find(1)->role()->attach(1);
        // \App\Models\User::find(2)->role()->attach(2);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
