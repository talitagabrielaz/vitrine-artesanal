<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $produtos = [
            ['nome' => 'Vaso de Cerâmica', 'descricao' => 'Vaso feito à mão com argila natural', 'preco' => 89.90, 'categoria_id' => 1, 'usuario_id' => $user->id],
            ['nome' => 'Prato Decorativo', 'descricao' => 'Prato pintado com motivos regionais', 'preco' => 65.00, 'categoria_id' => 1, 'usuario_id' => $user->id],
            ['nome' => 'Tapete Trançado', 'descricao' => 'Tapete colorido feito no tear', 'preco' => 120.00, 'categoria_id' => 2, 'usuario_id' => $user->id],
            ['nome' => 'Toalha Bordada', 'descricao' => 'Toalha com bordado floral', 'preco' => 45.00, 'categoria_id' => 2, 'usuario_id' => $user->id],
            ['nome' => 'Escultura em Madeira', 'descricao' => 'Escultura entalhada à mão', 'preco' => 200.00, 'categoria_id' => 3, 'usuario_id' => $user->id],
        ];

        foreach ($produtos as $produto) {
            DB::table('produtos')->insert($produto);
        }
    }
}