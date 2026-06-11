# Produtos Artesanais

Sistema de cadastro de produtos artesanais com imagem e catálogo em PDF.

**Trabalho de criação de site — Projeto Laravel**
Autores: Matheus Lucas, Talita Gabriela

---

## Tema

Cadastro de produtos artesanais com imagem e catálogo (PDF).

---

## Requisitos obrigatórios

### Telas
- Tela de login
- Tela de cadastro de usuário
- Dashboard (home admin)
- Navbar na área administrativa
- Landing page pública
- Cadastro de dados principais
- Listagem de registros
- Edição de registros
- Exclusão de registros

### Funcionalidades técnicas
- Upload de imagem
- Upload de arquivo PDF
- Visualização ou download dos arquivos
- Integração com banco de dados
- Uso de Blade
- Uso de Bootstrap
- Uso de CSS personalizado
- Uso de JavaScript puro

---

## Modelagem do banco de dados

### Tabelas

**`usuarios`** — Administradores do sistema

| Campo       | Tipo         | Observação            |
|-------------|--------------|-----------------------|
| id          | integer      | PK, auto-increment    |
| nome        | varchar      |                       |
| email       | varchar      | unique, not null      |
| senha       | varchar      | not null              |
| created_at  | timestamp    |                       |

**`categorias`** — Organização do catálogo

| Campo      | Tipo     | Observação         |
|------------|----------|--------------------|
| id         | integer  | PK, auto-increment |
| nome       | varchar  | not null           |
| descricao  | text     |                    |

**`produtos`** — Onde ficam imagens e PDFs

| Campo             | Tipo           | Observação                          |
|-------------------|----------------|-------------------------------------|
| id                | integer        | PK, auto-increment                  |
| nome              | varchar        | not null                            |
| descricao         | text           |                                     |
| preco             | decimal(10,2)  |                                     |
| imagem_url        | varchar        | Caminho do upload da imagem         |
| catalogo_pdf_url  | varchar        | Caminho do upload do PDF            |
| usuario_id        | integer        | FK → usuarios.id                    |
| categoria_id      | integer        | FK → categorias.id                  |
| created_at        | timestamp      |                                     |

### Relacionamentos
- Um **usuário** cadastra muitos **produtos** (`usuarios.id` ← `produtos.usuario_id`)
- Uma **categoria** pertence a muitos **produtos** (`categorias.id` ← `produtos.categoria_id`)

---

## Etapas de entrega

### 1ª Etapa — Requisitos do sistema
- Nome do sistema, objetivo e público-alvo
- Problema que o sistema resolve
- Principais funcionalidades
- Descrição das telas e da área administrativa
- Descrição da landing page
- Casos de uso (mínimo 3)
- Fluxo do sistema

### 2ª Etapa — Modelagem do banco de dados
- Definição das tabelas e campos
- Relacionamentos entre tabelas
- Descrição das tabelas
- Migrations

### 3ª Etapa — Criação do projeto e repositório
- Projeto Laravel criado
- Repositório configurado (GitHub/GitLab)
- Commits organizados
- README do projeto

### 4ª Etapa — Estrutura do backend
- Rotas definidas
- Controllers e Models criados
- Migrations funcionando
- Conexão com banco de dados ativa

### 5ª Etapa — Interface (front-end)
- Páginas Blade criadas
- Bootstrap aplicado
- Layout organizado
- Landing page funcional
- Navbar administrativa

### 6ª Etapa — Apresentação prévia
- Demonstrar estrutura do projeto
- Backend criado e banco de dados
- Telas iniciadas
- Funcionamento parcial — não precisa estar perfeito

### 7ª Etapa — Apresentação final *(+1 ponto)*
- Sistema completamente funcional
- Navegação completa entre as telas
- Explicação do código
- Demonstração de todas as funcionalidades
