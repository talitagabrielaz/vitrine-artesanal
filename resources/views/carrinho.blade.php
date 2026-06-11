@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 900px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('landing') }}" class="btn btn-outline-secondary btn-sm">← Continuar comprando</a>
        <h1 class="mb-0" style="font-family: 'Cormorant Garamond', serif;">🛒 Meu Carrinho</h1>
    </div>

    {{-- Carrinho vazio --}}
    <div id="carrinho-vazio" class="text-center py-5 d-none">
        <p style="font-size: 3rem;">🛍️</p>
        <h4 style="font-family: 'Cormorant Garamond', serif; color: #9a7060;">Seu carrinho está vazio</h4>
        <p class="text-muted mb-4">Que tal explorar nossos produtos artesanais?</p>
        <a href="{{ route('landing') }}" class="btn btn-primary">Ver produtos</a>
    </div>

    {{-- Itens do carrinho --}}
    <div id="carrinho-conteudo">
        <div class="row g-4">
            {{-- Lista de itens --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header" style="font-family: 'Cormorant Garamond', serif; font-size: 1.1rem;">
                        Itens no carrinho
                    </div>
                    <div class="card-body p-0">
                        <div id="lista-itens"></div>
                    </div>
                </div>
            </div>

            {{-- Resumo --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header" style="font-family: 'Cormorant Garamond', serif; font-size: 1.1rem;">
                        Resumo do pedido
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span id="subtotal">R$ 0,00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Frete</span>
                            <span class="text-success">Grátis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="total" style="color: #3d2b1f; font-size: 1.2rem;">R$ 0,00</strong>
                        </div>
                        <button class="btn btn-primary w-100 mb-2" onclick="finalizarCompra()">
                            Finalizar compra
                        </button>
                        <button class="btn btn-outline-secondary w-100 btn-sm" onclick="limparCarrinho()">
                            Limpar carrinho
                        </button>
                    </div>
                </div>

                {{-- Cupom --}}
                <div class="card mt-3">
                    <div class="card-body">
                        <p class="mb-2" style="font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Cupom de desconto</p>
                        <div class="d-flex gap-2">
                            <input type="text" id="cupom" class="form-control form-control-sm" placeholder="Digite o cupom">
                            <button class="btn btn-sm btn-outline-secondary" onclick="aplicarCupom()">Aplicar</button>
                        </div>
                        <small id="msg-cupom" class="mt-1 d-block"></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal confirmação de compra --}}
    <div class="modal fade" id="modalConfirmar" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content text-center">
                <div class="modal-body py-4">
                    <p style="font-size: 3rem;">✅</p>
                    <h5 style="font-family: 'Cormorant Garamond', serif;">Pedido realizado!</h5>
                    <p class="text-muted small">Obrigado pela sua compra. Em breve entraremos em contato.</p>
                    <a href="{{ route('landing') }}" class="btn btn-primary mt-2">Voltar à loja</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
let carrinho = JSON.parse(localStorage.getItem('carrinho') || '[]');
let desconto = 0;

function fmt(valor) {
    return 'R$ ' + valor.toFixed(2).replace('.', ',');
}

function calcTotal() {
    const subtotal = carrinho.reduce((s, i) => s + i.preco * i.qtd, 0);
    const total = subtotal - desconto;
    document.getElementById('subtotal').textContent = fmt(subtotal);
    document.getElementById('total').textContent = fmt(total < 0 ? 0 : total);
}

function renderizar() {
    const lista = document.getElementById('lista-itens');
    const vazio = document.getElementById('carrinho-vazio');
    const conteudo = document.getElementById('carrinho-conteudo');

    if (carrinho.length === 0) {
        vazio.classList.remove('d-none');
        conteudo.classList.add('d-none');
        return;
    }

    vazio.classList.add('d-none');
    conteudo.classList.remove('d-none');

    lista.innerHTML = carrinho.map((item, index) => `
        <div class="d-flex align-items-center gap-3 p-3 border-bottom">
            <div class="flex-grow-1">
                <h6 class="mb-1" style="font-family: 'Cormorant Garamond', serif;">${item.nome}</h6>
                <small class="text-muted">${fmt(item.preco)} cada</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm" style="width:30px;height:30px;padding:0;" onclick="alterarQtd(${index}, -1)">−</button>
                <span style="min-width: 24px; text-align: center;">${item.qtd}</span>
                <button class="btn btn-outline-secondary btn-sm" style="width:30px;height:30px;padding:0;" onclick="alterarQtd(${index}, 1)">+</button>
            </div>
            <div style="min-width: 80px; text-align: right;">
                <strong>${fmt(item.preco * item.qtd)}</strong>
            </div>
            <button class="btn btn-sm btn-outline-danger" onclick="remover(${index})" title="Remover">✕</button>
        </div>
    `).join('');

    calcTotal();
}

function alterarQtd(index, delta) {
    carrinho[index].qtd += delta;
    if (carrinho[index].qtd <= 0) {
        carrinho.splice(index, 1);
    }
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    renderizar();
}

function remover(index) {
    carrinho.splice(index, 1);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    renderizar();
}

function limparCarrinho() {
    if (confirm('Deseja limpar o carrinho?')) {
        carrinho = [];
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        renderizar();
    }
}

function finalizarCompra() {
    new bootstrap.Modal(document.getElementById('modalConfirmar')).show();
    carrinho = [];
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
}

function aplicarCupom() {
    const cupom = document.getElementById('cupom').value.trim().toUpperCase();
    const msg = document.getElementById('msg-cupom');
    const subtotal = carrinho.reduce((s, i) => s + i.preco * i.qtd, 0);

    if (cupom === 'ARTESANAL10') {
        desconto = subtotal * 0.10;
        msg.textContent = '✅ Desconto de 10% aplicado!';
        msg.style.color = 'green';
    } else if (cupom === 'FRETE') {
        msg.textContent = '✅ Frete já é grátis!';
        msg.style.color = 'green';
    } else {
        desconto = 0;
        msg.textContent = '❌ Cupom inválido.';
        msg.style.color = 'red';
    }
    calcTotal();
}

renderizar();
</script>
@endsection