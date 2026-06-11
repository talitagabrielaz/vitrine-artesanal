@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px">
    <h1 class="mb-4">Editar categoria</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('categorias.update', $categoria) }}">
                @method('PUT')
                @include('categorias._form', ['submitLabel' => 'Salvar alterações'])
            </form>
        </div>
    </div>
</div>
@endsection
