<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('produtos')->orderBy('nome')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        Categoria::create($this->validated($request));

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoria cadastrada com sucesso.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $categoria->update($this->validated($request));

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->produtos()->exists()) {
            return back()->withErrors([
                'categoria' => 'Não é possível excluir uma categoria com produtos vinculados.',
            ]);
        }

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('status', 'Categoria removida com sucesso.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
        ]);
    }
}
