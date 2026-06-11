<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with(['categoria', 'usuario'])
            ->latest()
            ->paginate(10);

        return view('produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['usuario_id'] = $request->user()->id;
        $data['imagem_url'] = $this->uploadIfPresent($request, 'imagem', 'produtos/imagens');
        $data['catalogo_pdf_url'] = $this->uploadIfPresent($request, 'catalogo_pdf', 'produtos/catalogos');

        Produto::create($data);

        return redirect()
            ->route('produtos.index')
            ->with('status', 'Produto cadastrado com sucesso.');
    }

    public function show(Produto $produto)
    {
        $produto->load(['categoria', 'usuario']);

        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::orderBy('nome')->get();

        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        $data = $this->validated($request);

        if ($path = $this->uploadIfPresent($request, 'imagem', 'produtos/imagens')) {
            $this->deleteFile($produto->imagem_url);
            $data['imagem_url'] = $path;
        }

        if ($path = $this->uploadIfPresent($request, 'catalogo_pdf', 'produtos/catalogos')) {
            $this->deleteFile($produto->catalogo_pdf_url);
            $data['catalogo_pdf_url'] = $path;
        }

        $produto->update($data);

        return redirect()
            ->route('produtos.index')
            ->with('status', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $this->deleteFile($produto->imagem_url);
        $this->deleteFile($produto->catalogo_pdf_url);
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('status', 'Produto removido com sucesso.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'preco' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'imagem' => ['nullable', 'image', 'max:4096'],
            'catalogo_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);
    }

    private function uploadIfPresent(Request $request, string $field, string $folder): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $request->file($field)->store($folder, 'public');
    }

    private function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
