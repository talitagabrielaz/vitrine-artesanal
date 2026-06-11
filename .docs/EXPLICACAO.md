# O projeto explicado por partes

Explicação completa do que é o sistema, como funciona e o que cada tecnologia faz. Pensado pra quem não programa mas precisa entender o esqueleto.

---

## 1. O que o sistema faz

É um **catálogo de produtos artesanais**, com duas faces:

- **Área pública (landing page):** qualquer visitante abre no navegador e vê todos os produtos cadastrados, com foto, preço, descrição e link pra baixar um catálogo em PDF. Tem um filtro por categoria.
- **Área administrativa:** protegida por login. O admin entra, cadastra/edita/remove produtos, faz upload de imagem e PDF, e gerencia categorias.

Em uma frase: **é um e-commerce simplificado (sem carrinho de compras), focado em mostrar produtos.**

---

## 2. A arquitetura de um relance

```
┌───────────────┐     1. clica em link        ┌──────────────────┐
│   Navegador   │ ──────────────────────────► │  Servidor PHP    │
│   (Chrome)    │                             │   (Laravel)      │
│               │ ◄────────────────────────── │                  │
└───────────────┘     4. recebe HTML pronto   └────────┬─────────┘
                                                       │ 2. pergunta dados
                                                       ▼
                                              ┌──────────────────┐
                                              │  Banco MySQL     │
                                              │   (tabelas)      │
                                              └──────────────────┘
                                                       │ 3. devolve dados
                                                       │    (Laravel monta o HTML)
```

Tudo isso roda **dentro do Docker** no seu computador. Não existe servidor remoto, é tudo local enquanto você desenvolve.

---

## 3. A stack — o que é cada peça

### Backend (o "cérebro" do sistema)

| Tecnologia | O que é | Pra que serve aqui |
|---|---|---|
| **PHP 8.5** | Linguagem de programação | Roda as regras de negócio (cadastrar produto, validar login, etc) |
| **Laravel 13** | "Framework" PHP — uma caixa de ferramentas pronta | Acelera quase tudo: rotas, validação, banco, login, upload |
| **MySQL 8.4** | Banco de dados | Onde os produtos, categorias e usuários ficam guardados |
| **Composer** | Gerenciador de bibliotecas PHP | Baixa e atualiza pacotes (Laravel, etc) |

### Frontend (o que aparece no navegador)

| Tecnologia | O que é | Pra que serve aqui |
|---|---|---|
| **Blade** | Sistema de templates do Laravel | Mistura HTML com dados do banco (igual `{{ $produto->nome }}`) |
| **Bootstrap 5** | Biblioteca de CSS pronta | Componentes visuais (botões, cards, navbar) sem fazer do zero |
| **CSS personalizado** | Estilo próprio | Pequenos ajustes específicos do projeto |
| **JavaScript puro** | Interatividade no navegador | Filtro de categorias na landing (sem framework) |
| **Vite** | Compilador de assets | Junta SCSS + JS em arquivos finais otimizados |

### Infraestrutura (o que faz tudo rodar)

| Tecnologia | O que é | Pra que serve aqui |
|---|---|---|
| **Docker** | Sistema de containers | Empacota PHP + MySQL + tudo num "ambiente isolado" |
| **Laravel Sail** | Configuração Docker pronta do Laravel | Define os containers em um arquivo (`compose.yaml`) |

---

## 4. Como o backend funciona (passo a passo de uma request)

Imagine que um visitante clica em "Editar produto" na listagem. O que acontece:

1. **Navegador** dispara `GET http://localhost/produtos/5/edit`.
2. **Laravel** abre `routes/web.php` e procura quem responde por essa URL. Acha:
   ```php
   Route::resource('produtos', ProdutoController::class);
   ```
3. Resolve: rota `produtos.edit` → método `edit()` da classe `ProdutoController`.
4. O método `edit()`:
   - Busca o produto de id 5 no banco usando o **Model** `Produto`.
   - Busca todas as categorias (pra preencher o `<select>`).
   - Chama a **view** `produtos.edit`, passando esses dados.
5. A view `resources/views/produtos/edit.blade.php` é um arquivo HTML com pedaços tipo `{{ $produto->nome }}`. O Blade substitui isso pelo valor real.
6. Laravel devolve o HTML pronto pro navegador.

**Os 4 atores principais do Laravel:**

- **Route** (`routes/web.php`): "tal URL chama tal função"
- **Controller** (`app/Http/Controllers/`): a função que decide o que fazer
- **Model** (`app/Models/`): representa uma tabela no banco como um objeto PHP
- **View** (`resources/views/`): o HTML que vai pro navegador

Quem programa em Laravel ouve isso o tempo todo. É o padrão **MVC** (Model-View-Controller) com Routes em cima.

---

## 5. O banco de dados

São **3 tabelas** principais:

```
┌──────────────┐         ┌──────────────┐
│  usuarios    │         │  categorias  │
├──────────────┤         ├──────────────┤
│ id           │         │ id           │
│ nome         │         │ nome         │
│ email        │         │ descricao    │
│ senha        │         └──────┬───────┘
└──────┬───────┘                │
       │                        │
       │   ┌────────────────────┴─────┐
       │   │                          │
       │   ▼                          │
       │ ┌──────────────────────┐     │
       └─┤  produtos            │     │
         ├──────────────────────┤     │
         │ id                   │     │
         │ nome                 │     │
         │ descricao            │     │
         │ preco                │     │
         │ imagem_url           │     │
         │ catalogo_pdf_url     │     │
         │ usuario_id (FK) ─────┘     │
         │ categoria_id (FK) ─────────┘
         └──────────────────────┘
```

**Relacionamentos em palavras:**
- Um **usuário** pode cadastrar **vários produtos** (1-para-muitos)
- Uma **categoria** agrupa **vários produtos** (1-para-muitos)
- Cada **produto** pertence a **um usuário** e **uma categoria**

### Migrations — como as tabelas são criadas

Em vez de criar tabelas manualmente no MySQL, o Laravel usa arquivos PHP que descrevem as tabelas em `database/migrations/`. Quando você roda `php artisan migrate`, o Laravel lê esses arquivos e cria as tabelas correspondentes. Vantagem: **a estrutura do banco fica versionada junto com o código**, qualquer um clonando o projeto monta o banco com um comando.

---

## 6. Autenticação (login e cadastro)

Foi usado o pacote `laravel/ui` que gera tudo pronto:

- Tela de login (`/login`)
- Tela de cadastro (`/register`)
- Logout
- Recuperação de senha (não habilitado por padrão, mas vem na carona)

**O fluxo simplificado:**

1. Usuário preenche email + senha em `/login` e clica em "Entrar".
2. Laravel busca esse email na tabela `usuarios`.
3. Compara a senha digitada com a senha **hasheada** guardada no banco (com bcrypt — uma forma matemática irreversível de embaralhar). Senha nunca é guardada em texto puro, por isso ninguém consegue ver a senha real nem com acesso direto ao banco.
4. Se bate, o Laravel cria uma **sessão** (um cookie no navegador) e o usuário fica logado.
5. Em toda página protegida, o Laravel checa esse cookie. Se não tiver, manda pra tela de login.

A proteção das rotas administrativas é feita aqui (`routes/web.php`):
```php
Route::middleware('auth')->group(function () {
    // rotas que só logado acessa
});
```

---

## 7. Upload de imagens e PDFs

Quando o admin cadastra um produto com imagem:

1. O formulário tem `enctype="multipart/form-data"` (sem isso o navegador não envia arquivos).
2. Laravel recebe o arquivo em `$request->file('imagem')`.
3. Salva no disco usando `$file->store('produtos/imagens', 'public')`.
4. Isso copia o arquivo pra `storage/app/public/produtos/imagens/` e devolve um caminho tipo `produtos/imagens/abc123.jpg`.
5. Esse caminho é gravado na coluna `imagem_url` do produto.
6. Pra mostrar a imagem no HTML, o Blade usa `Storage::url($produto->imagem_url)` que gera `/storage/produtos/imagens/abc123.jpg`.
7. Existe um **symlink** (atalho) `public/storage` → `storage/app/public` criado pelo comando `php artisan storage:link`. Por isso a URL `/storage/...` funciona no navegador.

PDFs seguem exatamente o mesmo fluxo, só muda a pasta (`produtos/catalogos`).

---

## 8. Como o frontend é montado

### Blade — o motor de templates

Arquivos `.blade.php` são **HTML com superpoderes**:

```blade
@foreach ($produtos as $produto)
    <h2>{{ $produto->nome }}</h2>
    <p>R$ {{ $produto->preco }}</p>
@endforeach
```

O `@foreach` é loop, `{{ }}` interpola variáveis. O Laravel pré-compila esses arquivos pra PHP antes de servir, então é rápido.

**Estrutura usada aqui:**
- `layouts/app.blade.php` → casca padrão (navbar, header, footer)
- `home.blade.php`, `produtos/index.blade.php`, etc. → cada página estende o layout e preenche o "conteúdo"

Isso usa o sistema de herança do Blade:
```blade
@extends('layouts.app')

@section('content')
    <!-- conteúdo específico da página -->
@endsection
```

### Bootstrap — o visual

Bootstrap é uma biblioteca CSS com **classes pré-prontas**. Em vez de escrever CSS pra fazer um botão azul arredondado, você só usa `class="btn btn-primary"` e tá feito.

No projeto, foi instalado o **scaffolding oficial** do `laravel/ui` que já vem com tudo configurado: navbar responsiva, formulários estilizados, sistema de grid (linhas/colunas).

### CSS personalizado

Quando o Bootstrap não cobre algo específico, escrevemos CSS em `resources/sass/app.scss`. O arquivo importa o Bootstrap e adiciona ajustes.

### JavaScript puro

A landing page tem um filtro por categoria que esconde/mostra cards conforme você clica em um botão. Isso é feito em JS puro (sem React, Vue, etc.), em um `<script>` direto no Blade. Veja `resources/views/landing.blade.php`.

### Vite — quem amarra tudo

Quando você roda `npm run build`:
1. Vite lê `resources/sass/app.scss` (que importa Bootstrap).
2. Compila SCSS pra CSS, minifica, gera `public/build/app-XXX.css`.
3. Faz o mesmo com `resources/js/app.js` → `public/build/app-XXX.js`.
4. Gera um `manifest.json` mapeando os nomes.
5. No Blade, a diretiva `@vite([...])` lê o manifest e injeta as tags `<link>` e `<script>` corretas.

Sem isso a página carregaria os arquivos crus, demoraria mais e não teria minificação.

---

## 9. Como o Docker entra na história

Sem Docker, você teria que instalar:
- PHP 8.5 + 20 extensões específicas
- Composer
- MySQL 8.4
- Node 24
- Configurar tudo manualmente
- E rezar pra funcionar em outro Windows com versões diferentes

Com Docker:
- Tudo isso vem empacotado em **imagens** (templates de container).
- O arquivo `compose.yaml` descreve quais containers subir e como conectá-los.
- Um `docker compose up -d` instala/sobe tudo.
- Qualquer pessoa que clonar o projeto roda **o mesmo comando** e tem **o mesmo ambiente**.

São dois containers neste projeto:
1. **`laravel.test`** — onde rodam PHP, Node e a aplicação Laravel
2. **`mysql`** — o banco de dados, isolado

Eles se enxergam por uma rede interna do Docker. Dentro do container PHP, o "host" do banco é literalmente `mysql` (o nome do serviço no `compose.yaml`).

---

## 10. O que mexer onde

Cheat sheet pra programar:

| Quero... | Mexo em |
|---|---|
| Adicionar uma página nova | `routes/web.php` + criar controller em `app/Http/Controllers/` + view em `resources/views/` |
| Mudar o visual de uma tela | `resources/views/<pasta>/<arquivo>.blade.php` |
| Adicionar uma coluna numa tabela | Crio nova migration: `docker compose exec laravel.test php artisan make:migration add_X_to_Y` |
| Mudar estilos globais | `resources/sass/app.scss` (e rodar `npm run build` depois) |
| Adicionar JS na landing | Direto no `<script>` dentro de `resources/views/landing.blade.php` |
| Mudar configs (banco, mail, etc) | `.env` (NUNCA commitar esse arquivo no git, contém senhas) |

---

## 11. Resumo final pra apresentação

Se precisar explicar em 30 segundos:

> "É um sistema de catálogo de produtos artesanais feito em Laravel (framework PHP) com banco MySQL, todo rodando em containers Docker pra não precisar instalar nada na máquina. O backend usa o padrão MVC: rotas mapeiam URLs pra controllers, que buscam dados via models (cada model representa uma tabela) e devolvem views renderizadas com Blade. O frontend usa Bootstrap pra visual, CSS personalizado pra ajustes finos, e JavaScript puro pra o filtro de categorias na landing. Os assets passam por um build com Vite que minifica e otimiza. Login usa o pacote oficial `laravel/ui` com senhas hasheadas via bcrypt. Upload de imagem e PDF usa o sistema de Storage do Laravel com link público."
