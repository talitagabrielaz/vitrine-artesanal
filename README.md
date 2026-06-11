# 🪡 Produtos Artesanais

> Sistema web de cadastro e exibição de produtos artesanais com imagem e catálogo em PDF.

![Laravel](https://img.shields.io/badge/Laravel-13.8-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?style=flat-square&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?style=flat-square&logo=bootstrap)
![SQLite](https://img.shields.io/badge/SQLite-banco%20de%20dados-lightblue?style=flat-square&logo=sqlite)

**Trabalho de criação de site — Projeto Laravel**  
👤 Autores: **Matheus Lucas** e **Talita Gabriela**

---

## 📌 Sobre o projeto

O **Produtos Artesanais** é um sistema web desenvolvido em Laravel que permite o cadastro, edição e exibição de produtos artesanais. O sistema conta com uma área administrativa protegida por login e uma landing page pública para visualização do catálogo.

---

## ✅ Funcionalidades

- 🔐 Login e cadastro de usuário
- 🏠 Dashboard administrativo
- 📦 Cadastro, edição, listagem e exclusão de produtos
- 🗂️ Gerenciamento de categorias
- 🖼️ Upload de imagem por produto
- 📄 Upload de catálogo em PDF
- 🌐 Landing page pública com filtro por categoria
- 📱 Layout responsivo com Bootstrap

---

## 🗄️ Modelagem do banco de dados

### Tabelas

**`usuarios`** — Administradores do sistema

| Campo      | Tipo      | Observação         |
|------------|-----------|--------------------|
| id         | integer   | PK, auto-increment |
| nome       | varchar   |                    |
| email      | varchar   | unique, not null   |
| senha      | varchar   | not null           |
| created_at | timestamp |                    |

**`categorias`** — Organização do catálogo

| Campo     | Tipo    | Observação         |
|-----------|---------|--------------------|
| id        | integer | PK, auto-increment |
| nome      | varchar | not null           |
| descricao | text    |                    |

**`produtos`** — Produtos com imagens e PDFs

| Campo            | Tipo          | Observação                  |
|------------------|---------------|-----------------------------|
| id               | integer       | PK, auto-increment          |
| nome             | varchar       | not null                    |
| descricao        | text          |                             |
| preco            | decimal(10,2) |                             |
| imagem_url       | varchar       | Caminho do upload da imagem |
| catalogo_pdf_url | varchar       | Caminho do upload do PDF    |
| usuario_id       | integer       | FK → usuarios.id            |
| categoria_id     | integer       | FK → categorias.id          |
| created_at       | timestamp     |                             |

### Relacionamentos
- Um **usuário** cadastra muitos **produtos**
- Uma **categoria** pertence a muitos **produtos**

---

## 🚀 Como rodar o projeto

### Pré-requisitos
- PHP 8.3+
- Composer
- Node.js e NPM

### Passo a passo

```bash
# 1. Instalar dependências PHP
composer install

# 2. Copiar o arquivo de ambiente
cp .env.example .env

# 3. Gerar a chave da aplicação
php artisan key:generate

# 4. Criar o banco de dados e rodar as migrations
php artisan migrate

# 5. Popular o banco com dados iniciais
php artisan db:seed

# 6. Criar link de storage para uploads
php artisan storage:link

# 7. Instalar dependências JS e buildar assets
npm install
npm run build

# 8. Rodar o servidor
php artisan serve
```

Acesse em: **http://127.0.0.1:8000**

### Login padrão
- **Email:** admin@artesanal.local
- **Senha:** senha1234

---

## 🏗️ Estrutura do projeto

```
├── app/
│   ├── Http/Controllers/   # Controllers do sistema
│   └── Models/             # Models (User, Produto, Categoria)
├── database/
│   ├── migrations/         # Migrations das tabelas
│   └── seeders/            # Seeds com dados iniciais
├── resources/
│   ├── views/              # Telas Blade
│   │   ├── layouts/        # Layout principal
│   │   ├── produtos/       # Telas de produtos
│   │   ├── categorias/     # Telas de categorias
│   │   └── auth/           # Login e registro
│   └── sass/               # Estilos personalizados
└── routes/
    └── web.php             # Rotas da aplicação
```

---

## 📋 Etapas de entrega

| Etapa | Descrição | Status |
|-------|-----------|--------|
| 1ª | Requisitos do sistema | ✅ |
| 2ª | Modelagem do banco de dados | ✅ |
| 3ª | Criação do projeto e repositório | ✅ |
| 4ª | Estrutura do backend | ✅ |
| 5ª | Interface (front-end) | ✅ |
| 6ª | Apresentação prévia | ✅ |
| 7ª | Apresentação final | 🔄 |

---

## 🛠️ Tecnologias utilizadas

- **Laravel 13** — Framework PHP
- **PHP 8.3** — Linguagem backend
- **SQLite** — Banco de dados
- **Bootstrap 5** — Framework CSS
- **Blade** — Template engine
- **Vite** — Bundler de assets
- **JavaScript** — Interatividade frontend
