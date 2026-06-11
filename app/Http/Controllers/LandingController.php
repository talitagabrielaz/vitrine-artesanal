<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;

class LandingController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->latest()->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('landing', compact('produtos', 'categorias'));
    }
}
