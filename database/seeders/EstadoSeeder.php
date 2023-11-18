<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado')->insert([
            ['uf' => 'AC', 'nome' => 'ACRE', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'AL', 'nome' => 'ALAGOAS', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'AM', 'nome' => 'AMAZONAS', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'AP', 'nome' => 'AMAPÁ', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'BA', 'nome' => 'BAHIA', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'CE', 'nome' => 'CEARÁ', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'DF', 'nome' => 'DISTRITO FEDERAL', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'ES', 'nome' => 'ESPÍRITO SANTO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'GO', 'nome' => 'GOIÁS', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'MA', 'nome' => 'MARANHÃO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'MG', 'nome' => 'MINAS GERAIS', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'MS', 'nome' => 'MATO GROSSO DO SUL', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'MT', 'nome' => 'MATO GROSSO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'PA', 'nome' => 'PARÁ', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'PB', 'nome' => 'PARAÍBA', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'PE', 'nome' => 'PERNAMBUCO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'PI', 'nome' => 'PIAUÍ', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'PR', 'nome' => 'PARANÁ', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'RJ', 'nome' => 'RIO DE JANEIRO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'RN', 'nome' => 'RIO GRANDE DO NORTE', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'RO', 'nome' => 'RONDÔNIA', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'RR', 'nome' => 'RORAIMA', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'RS', 'nome' => 'RIO GRANDE DO SUL', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'SC', 'nome' => 'SANTA CATARINA', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'SE', 'nome' => 'SERGIPE', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'SP', 'nome' => 'SÃO PAULO', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()],
            ['uf' => 'TO', 'nome' => 'TOCANTINS', "created_at" => \Carbon\Carbon::now(), "updated_at" => \Carbon\Carbon::now()]
        ]);
    }
}
