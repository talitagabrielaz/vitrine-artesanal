@extends('layouts.app')

@section('content')
{{-- HERO --}}
<section class="py-5 mb-4" style="background-color: #f7f2ec;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold" style="font-family: 'Cormorant Garamond', serif; color: #3d2b1f;">Produtos Artesanais</h1>
        <p class="lead" style="color: #9a7060;">Catálogo de peças feitas à mão, com história e cuidado.</p>

        {{-- Barra de pesquisa --}}
        <div class="mt-3 d-flex justify-content-center">
            <input type="text" id="busca" class="form-control" style="max-width: 400px;" placeholder="🔍 Pesquisar produto...">
        </div>
    </div>
</section>

<div class="container">

    {{-- Notificação carrinho --}}
    <div id="notif" class="alert alert-success d-none" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 250px;"></div>

    {{-- Filtros por categoria --}}
    @if ($categorias->isNotEmpty())
        <div class="mb-4 d-flex flex-wrap gap-2 align-items-center" id="filtro">
            <span class="text-muted me-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Filtrar:</span>
            <button type="button" class="btn btn-sm btn-dark filtro-btn active" data-categoria="todas">Todas</button>
            @foreach ($categorias as $categoria)
                <button type="button" class="btn btn-sm btn-outline-dark filtro-btn" data-categoria="{{ $categoria->id }}">{{ $categoria->nome }}</button>
            @endforeach
        </div>
    @endif

    {{-- Resumo carrinho --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('carrinho') }}" class="btn btn-outline-secondary btn-sm">
            🛒 Carrinho <span id="qtd-carrinho" class="badge bg-dark">0</span>
        </a>
    </div>

    @if ($produtos->isEmpty())
        <p class="text-muted text-center py-5">Nenhum produto disponível no momento.</p>
    @else
        <div class="row g-4" id="produtos-grid">
            @foreach ($produtos as $produto)
                <div class="col-sm-6 col-md-4 col-lg-3 produto-card" data-categoria="{{ $produto->categoria_id }}" data-nome="{{ strtolower($produto->nome) }}">
                    <div class="card h-100 shadow-sm" style="cursor: pointer; transition: transform 0.2s;" onmouseenter="this.style.transform='translateY(-4px)'" onmouseleave="this.style.transform='translateY(0)'">

                        {{-- Botão favorito --}}
                        <button class="btn-fav" onclick="toggleFav(this, {{ $produto->id }})" title="Favoritar"
                            style="position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.85); border: none; border-radius: 50%; width: 34px; height: 34px; font-size: 1.1rem; cursor: pointer; z-index: 1;">
                            ♡
                        </button>

                        @if ($produto->imagem_url)
                            <img src="{{ Storage::url($produto->imagem_url) }}" alt="{{ $produto->nome }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;"
                                onclick="abrirProduto({{ $produto->id }})">
                        @else
                            <div class="card-img-top bg-secondary-subtle d-flex align-items-center justify-content-center text-muted"
                                style="height: 200px;" onclick="abrirProduto({{ $produto->id }})">sem imagem</div>
                        @endif

                        <div class="card-body" onclick="abrirProduto({{ $produto->id }})">
                            <span class="badge bg-secondary mb-2">{{ $produto->categoria->nome }}</span>
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($produto->descricao, 80) }}</p>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center bg-white">
                            <strong>R$ {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                            <button class="btn btn-sm btn-primary"
                                onclick="adicionarCarrinho({{ $produto->id }}, '{{ addslashes($produto->nome) }}', {{ $produto->preco }})">
                                + Carrinho
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Dados do produto para o modal (hidden) --}}
                <div id="dados-{{ $produto->id }}" class="d-none"
                    data-nome="{{ $produto->nome }}"
                    data-preco="{{ number_format($produto->preco, 2, ',', '.') }}"
                    data-desc="{{ $produto->descricao }}"
                    data-cat="{{ $produto->categoria->nome }}"
                    data-img="{{ $produto->imagem_url ? Storage::url($produto->imagem_url) : '' }}"
                    data-pdf="{{ $produto->catalogo_pdf_url ? Storage::url($produto->catalogo_pdf_url) : '' }}">
                </div>
            @endforeach
        </div>

        <p class="text-muted text-center mt-4" id="vazio" hidden>Nenhum produto nessa categoria.</p>
    @endif
</div>

{{-- Modal produto --}}
<div class="modal fade" id="modalProduto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f0e8e0; border-bottom: 1px solid #ddd0c8;">
                <h5 class="modal-title" id="modal-nome" style="font-family: 'Cormorant Garamond', serif;"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img id="modal-img" src="" alt="" class="img-fluid rounded" style="max-height: 280px; object-fit: cover; width: 100%;">
                    </div>
                    <div class="col-md-7">
                        <span id="modal-cat" class="badge bg-secondary mb-2"></span>
                        <p id="modal-desc" class="text-muted mb-3"></p>
                        <h4 id="modal-preco" style="color: #3d2b1f;"></h4>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-primary" id="modal-btn-carrinho">+ Adicionar ao carrinho</button>
                            <a id="modal-pdf" href="#" target="_blank" class="btn btn-outline-danger d-none">Catálogo PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ===== CARRINHO =====
let carrinho = JSON.parse(localStorage.getItem('carrinho') || '[]');

function atualizarBadgeCarrinho() {
    const total = carrinho.reduce((s, i) => s + i.qtd, 0);
    document.getElementById('qtd-carrinho').textContent = total;
}

function adicionarCarrinho(id, nome, preco) {
    const existe = carrinho.find(i => i.id === id);
    if (existe) {
        existe.qtd++;
    } else {
        carrinho.push({ id, nome, preco, qtd: 1 });
    }
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarBadgeCarrinho();
    mostrarNotif(nome + ' adicionado ao carrinho!');
}

function mostrarNotif(msg) {
    const n = document.getElementById('notif');
    n.textContent = msg;
    n.classList.remove('d-none');
    setTimeout(() => n.classList.add('d-none'), 2500);
}

// ===== FAVORITOS =====
let favs = JSON.parse(localStorage.getItem('favs') || '[]');

function toggleFav(btn, id) {
    event.stopPropagation();
    if (favs.includes(id)) {
        favs = favs.filter(f => f !== id);
        btn.textContent = '♡';
        btn.style.color = '#3d2b1f';
    } else {
        favs.push(id);
        btn.textContent = '♥';
        btn.style.color = '#c0392b';
        mostrarNotif('Produto favoritado!');
    }
    localStorage.setItem('favs', JSON.stringify(favs));
}

// ===== MODAL PRODUTO =====
function abrirProduto(id) {
    const dados = document.getElementById('dados-' + id);
    document.getElementById('modal-nome').textContent = dados.dataset.nome;
    document.getElementById('modal-cat').textContent = dados.dataset.cat;
    document.getElementById('modal-desc').textContent = dados.dataset.desc || 'Sem descrição.';
    document.getElementById('modal-preco').textContent = 'R$ ' + dados.dataset.preco;

    const img = document.getElementById('modal-img');
    if (dados.dataset.img) {
        img.src = dados.dataset.img;
        img.classList.remove('d-none');
    } else {
        img.classList.add('d-none');
    }

    const pdf = document.getElementById('modal-pdf');
    if (dados.dataset.pdf) {
        pdf.href = dados.dataset.pdf;
        pdf.classList.remove('d-none');
    } else {
        pdf.classList.add('d-none');
    }

    const preco = parseFloat(dados.dataset.preco.replace(',', '.'));
    document.getElementById('modal-btn-carrinho').onclick = () => {
        adicionarCarrinho(id, dados.dataset.nome, preco);
    };

    new bootstrap.Modal(document.getElementById('modalProduto')).show();
}

// ===== FILTRO POR CATEGORIA =====
(function () {
    const botoes = document.querySelectorAll('.filtro-btn');
    const cards = document.querySelectorAll('.produto-card');
    const vazio = document.getElementById('vazio');

    botoes.forEach(function (btn) {
        btn.addEventListener('click', function () {
            botoes.forEach(function (b) {
                b.classList.remove('active', 'btn-dark');
                b.classList.add('btn-outline-dark');
            });
            btn.classList.add('active', 'btn-dark');
            btn.classList.remove('btn-outline-dark');

            const alvo = btn.dataset.categoria;
            filtrar(alvo, document.getElementById('busca').value);
        });
    });

    // ===== PESQUISA =====
    document.getElementById('busca').addEventListener('input', function () {
        const ativo = document.querySelector('.filtro-btn.active').dataset.categoria;
        filtrar(ativo, this.value);
    });

    function filtrar(categoria, texto) {
        let visiveis = 0;
        cards.forEach(function (card) {
            const catOk = categoria === 'todas' || card.dataset.categoria === categoria;
            const textoOk = !texto || card.dataset.nome.includes(texto.toLowerCase());
            const mostrar = catOk && textoOk;
            card.hidden = !mostrar;
            if (mostrar) visiveis++;
        });
        if (vazio) vazio.hidden = visiveis > 0;
    }
})();

// Inicializar badge
atualizarBadgeCarrinho();

// Restaurar favoritos
favs.forEach(id => {
    const btn = document.querySelector(`.btn-fav[onclick*="toggleFav(this, ${id})"]`);
    if (btn) { btn.textContent = '♥'; btn.style.color = '#c0392b'; }
});
</script>
@endsection