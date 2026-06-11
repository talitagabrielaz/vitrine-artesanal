@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ $produto->nome }}</h1>
        <div>
            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-outline-secondary">Editar</a>
            <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    <div class="card">
        @if ($produto->imagem_url)
            <img src="{{ Storage::url($produto->imagem_url) }}" alt="{{ $produto->nome }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
        @endif
        <div class="card-body">
            <div class="d-flex gap-2 mb-3">
                <span class="badge bg-secondary">{{ $produto->categoria->nome }}</span>
                <span class="badge bg-success">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
            </div>

            @if ($produto->descricao)
                <p>{{ $produto->descricao }}</p>
            @endif

            <dl class="row mb-0">
                <dt class="col-sm-3">Cadastrado por</dt>
                <dd class="col-sm-9">{{ $produto->usuario->nome }}</dd>

                <dt class="col-sm-3">Cadastrado em</dt>
                <dd class="col-sm-9">{{ $produto->created_at->format('d/m/Y H:i') }}</dd>

                @if ($produto->catalogo_pdf_url)
                    <dt class="col-sm-3">Catálogo</dt>
                    <dd class="col-sm-9">
                        <a href="{{ Storage::url($produto->catalogo_pdf_url) }}" target="_blank" class="btn btn-sm btn-outline-danger">Baixar PDF</a>
                    </dd>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection
