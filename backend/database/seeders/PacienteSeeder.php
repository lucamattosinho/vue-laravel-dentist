<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        Paciente::create([
            'first_name' => 'João',
            'last_name'=> 'Silva',
            'cpf' => '123.456.789-00',
            'phone' => '99999-9999',
        ]);
        Paciente::create([
            'first_name' => 'Maria',
            'last_name'=> 'Oliveira',
            'cpf' => '987.654.321-00',
            'phone' => '88888-8888',
        ]);
        Paciente::create([
            'first_name' => 'Carlos',
            'last_name'=> 'Santos',
            'cpf' => '456.789.123-00',
            'phone' => '77777-7777',
        ]);
        Paciente::create([
            'first_name' => 'Ana',
            'last_name'=> 'Costa',
            'cpf' => '321.654.987-00',
            'phone' => '66666-6666',
        ]);
        Paciente::create([
            'first_name' => 'Lucas',
            'last_name'=> 'Pereira',
            'cpf' => '654.321.987-00',
            'phone' => '55555-5555',
        ]);
    }
}
