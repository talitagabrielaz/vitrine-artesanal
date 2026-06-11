<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@artesanal.local'],
            [
                'nome' => 'Administrador',
                'senha' => 'senha1234',
            ],
        );

        foreach (['Cerâmica', 'Tecelagem', 'Madeira', 'Bordado'] as $nome) {
            Categoria::firstOrCreate(['nome' => $nome]);
        }

        $this->call(ProdutoSeeder::class);
    }
}