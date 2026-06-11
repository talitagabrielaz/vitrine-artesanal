@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $categoria->nome ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <textarea id="descricao" name="descricao" rows="3" class="form-control">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">{{ $submitLabel ?? 'Salvar' }}</button>
    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
