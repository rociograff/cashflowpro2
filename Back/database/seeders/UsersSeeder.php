<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre' => "Mario",
            'apellido' => "Perez",
            'usuario' => "marito",
            'email' => "marito@gmail.com",
            'paises' => 'Argentina',
            'password' => "123",
            'google_id' => null,
            'color' => "#C2185B",
            'sesion_iniciada' => '0',
        ]);

        User::create([
            'nombre' => "Marcia",
            'apellido' => "Kiimisch",
            'usuario' => "khaleesi",
            'email' => "mar@gmail.com",
            'paises' => 'Argentina',
            'password' => "123",
            'google_id' => null,
            'color' => "#C2185B",
            'sesion_iniciada' => '0',
        ]);

        User::create([
            'nombre' => "Maximiliano",
            'apellido' => "Hitter",
            'usuario' => "vikingo",
            'email' => "vikingo@gmail.com",
            'paises' => 'Argentina',
            'password' => "123",
            'google_id' => null,
            'color' => "#C2185B",
            'sesion_iniciada' => '0',
        ]);

        User::create([
            'nombre' => "Ramona",
            'apellido' => "Ortega",
            'usuario' => "mona",
            'email' => "mona@gmail.com",
            'paises' => 'Argentina',
            'password' => "123",
            'google_id' => null,
            'color' => "#C2185B",
            'sesion_iniciada' => '0',
        ]);
    }
}
