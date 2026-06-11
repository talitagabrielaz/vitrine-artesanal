@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px">
    <h1 class="mb-4">Cadastrar categoria</h1>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('categorias.store') }}">
                @include('categorias._form', ['submitLabel' => 'Cadastrar'])
            </form>
        </div>
    </div>
</div>
@endsection
