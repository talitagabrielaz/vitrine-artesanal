@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px">
    <h1 class="mb-4">Editar produto</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('produtos.update', $produto) }}" enctype="multipart/form-data">
                @method('PUT')
                @include('produtos._form', ['submitLabel' => 'Salvar alterações'])
            </form>
        </div>
    </div>
</div>
@endsection
