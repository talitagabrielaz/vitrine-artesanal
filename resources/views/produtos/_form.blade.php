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

<style>
    select.form-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: none !important;
    }
</style>

<div class="row g-3">
    <div class="col-md-8">
        <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
        <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $produto->nome ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label for="preco" class="form-label">Preço (R$) <span class="text-danger">*</span></label>
        <input type="number" step="0.01" min="0" id="preco" name="preco" class="form-control @error('preco') is-invalid @enderror" value="{{ old('preco', $produto->preco ?? '') }}" required>
    </div>

    <div class="col-md-12">
        <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
        <select id="categoria_id" name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" required>
            <option value="">— selecione —</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $produto->categoria_id ?? null) == $categoria->id)>{{ $categoria->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-12">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label for="imagem" class="form-label">Imagem (jpg/png, até 4MB)</label>
        <input type="file" id="imagem" name="imagem" accept="image/*" class="form-control @error('imagem') is-invalid @enderror">
        @if (! empty($produto->imagem_url))
            <small class="text-muted">Atual: <a href="{{ Storage::url($produto->imagem_url) }}" target="_blank">ver imagem</a></small>
        @endif
    </div>

    <div class="col-md-6">
        <label for="catalogo_pdf" class="form-label">Catálogo PDF (até 10MB)</label>
        <input type="file" id="catalogo_pdf" name="catalogo_pdf" accept="application/pdf" class="form-control @error('catalogo_pdf') is-invalid @enderror">
        @if (! empty($produto->catalogo_pdf_url))
            <small class="text-muted">Atual: <a href="{{ Storage::url($produto->catalogo_pdf_url) }}" target="_blank">ver PDF</a></small>
        @endif
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">{{ $submitLabel ?? 'Salvar' }}</button>
    <a href="{{ route('produtos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>