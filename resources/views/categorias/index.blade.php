@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Categorias</h1>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">+ Nova categoria</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            @if ($categorias->isEmpty())
                <p class="text-muted m-3 mb-0">Nenhuma categoria cadastrada.</p>
            @else
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th class="text-center">Produtos</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->nome }}</td>
                                <td class="text-muted">{{ \Illuminate\Support\Str::limit($categoria->descricao, 80) }}</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $categoria->produtos_count }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma a exclusão desta categoria?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" {{ $categoria->produtos_count > 0 ? 'disabled' : '' }}>Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="mt-3">{{ $categorias->links() }}</div>
</div>
@endsection
