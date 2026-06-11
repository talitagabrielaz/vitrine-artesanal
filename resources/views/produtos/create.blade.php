@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px">
    <h1 class="mb-4">Cadastrar produto</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
                @include('produtos._form', ['submitLabel' => 'Cadastrar'])
            </form>
        </div>
    </div>
</div>
@endsection
