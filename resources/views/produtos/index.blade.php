@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Produtos</h1>
        <a href="{{ route('produtos.create') }}" class="btn btn-primary">+ Novo produto</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if ($produtos->isEmpty())
                <p class="text-muted m-3 mb-0">Nenhum produto cadastrado.</p>
            @else
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 70px">Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th class="text-end">Preço</th>
                            <th>PDF</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td>
                                    @if ($produto->imagem_url)
                                        <img src="{{ Storage::url($produto->imagem_url) }}" alt="{{ $produto->nome }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('produtos.show', $produto) }}" class="text-decoration-none">{{ $produto->nome }}</a>
                                </td>
                                <td><span class="badge bg-secondary">{{ $produto->categoria->nome }}</span></td>
                                <td class="text-end">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                <td>
                                    @if ($produto->catalogo_pdf_url)
                                        <a href="{{ Storage::url($produto->catalogo_pdf_url) }}" target="_blank" class="btn btn-sm btn-outline-danger">PDF</a>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma a exclusão deste produto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="mt-3">
        {{ $produtos->links() }}
    </div>
</div>
@endsection
