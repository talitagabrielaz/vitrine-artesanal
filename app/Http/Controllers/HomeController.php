<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;

class HomeController extends Controller
{
    public function index()
    {
        $totalProdutos = Produto::count();
        $totalCategorias = Categoria::count();
        $ultimosProdutos = Produto::with('categoria')->latest()->take(5)->get();

        return view('home', compact('totalProdutos', 'totalCategorias', 'ultimosProdutos'));
    }
}
