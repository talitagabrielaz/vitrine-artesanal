@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-1">Produtos cadastrados</h6>
                    <p class="display-5 mb-0">{{ $totalProdutos }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small mb-1">Categorias</h6>
                    <p class="display-5 mb-0">{{ $totalCategorias }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Últimos produtos</span>
            <a href="{{ route('produtos.create') }}" class="btn btn-sm btn-primary">+ Novo produto</a>
        </div>
        <div class="card-body p-0">
            @if ($ultimosProdutos->isEmpty())
                <p class="text-muted m-3 mb-0">Nenhum produto cadastrado ainda.</p>
            @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th class="text-end">Preço</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ultimosProdutos as $produto)
                            <tr>
                                <td>{{ $produto->nome }}</td>
                                <td><span class="badge bg-secondary">{{ $produto->categoria->nome }}</span></td>
                                <td class="text-end">R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
