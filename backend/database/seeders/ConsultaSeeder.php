<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;
use App\Models\Paciente;

class ConsultaSeeder extends Seeder
{
    public function run(): void
    {
        $joao = Paciente::where('first_name', 'João')->first();
        $maria = Paciente::where('first_name', 'Maria')->first();
        $carlos = Paciente::where('first_name', 'Carlos')->first();
        $ana = Paciente::where('first_name', 'Ana')->first();
        $lucas = Paciente::where('first_name', 'Lucas')->first();

        Consulta::create([
            'paciente_id' => $joao->id,
            'data_hora' => '2025-04-10 14:00:00',
            'tratamento' => 'Extração',
            'descricao'=> 'Extração de dente siso',
        ]);

        Consulta::create([
            'paciente_id' => $maria->id,
            'data_hora' => '2025-04-11 10:30:00',
            'tratamento' => 'Limpeza',
            'descricao'=> 'Limpeza dental completa',
        ]);

        Consulta::create([
            'paciente_id' => $carlos->id,
            'data_hora' => '2025-04-12 09:00:00',
            'tratamento' => 'Restauração',
            'descricao'=> 'Restauração de dente cariado',
        ]);
        
        Consulta::create([
            'paciente_id' => $ana->id,
            'data_hora' => '2025-04-13 11:00:00',
            'tratamento' => 'Ortodontia',
            'descricao'=> 'Ajuste de aparelho ortodôntico',
        ]);

        Consulta::create([
            'paciente_id' => $lucas->id,
            'data_hora' => '2025-04-14 15:00:00',
            'tratamento' => 'Clareamento',
            'descricao'=> 'Clareamento dental',
        ]);
    }
}
