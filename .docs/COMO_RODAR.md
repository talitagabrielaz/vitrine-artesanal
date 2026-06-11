# Como rodar o projeto

Guia passo-a-passo para colocar o sistema no ar. Não precisa saber programar pra seguir.

---

## O que você precisa instalar antes

**Apenas uma coisa: Docker Desktop.**

Docker é um programa que cria "máquinas virtuais leves" (chamadas *containers*) dentro do seu computador. Em vez de você instalar PHP, MySQL, Node e mil coisas na sua máquina, o Docker faz tudo isso isolado dentro dele. Quando termina o trabalho, fecha o Docker e seu Windows continua limpo.

- Baixe em: https://www.docker.com/products/docker-desktop/
- Instale, reinicie o PC se pedir.
- Abra o Docker Desktop. Quando o ícone da baleinha na bandeja do Windows ficar **verde/estável**, ele tá rodando.

> **Importante:** O Docker precisa estar **rodando** (aberto) o tempo todo enquanto você usa o projeto.

---

## Primeira vez rodando (do zero)

Abra o **PowerShell** dentro da pasta do projeto (`laravel-project`). No Windows: clique com botão direito na pasta segurando Shift → "Abrir no Terminal" ou "Abrir PowerShell aqui".

Rode esses comandos **em ordem**:

### 1. Subir os containers

```powershell
docker compose up -d
```

Isso baixa as imagens (PHP, MySQL) e sobe dois containers: um da aplicação e um do banco de dados. Na primeira vez demora uns 5-10 min porque baixa tudo. Depois é instantâneo.

A flag `-d` é "detached" — roda em segundo plano, libera o terminal.

### 2. Esperar o banco ficar pronto

Espere uns 10 segundos depois do comando acima. O MySQL leva um tempo pra inicializar.

### 3. Aplicar as tabelas no banco

```powershell
docker compose exec laravel.test php artisan migrate --seed
```

`migrate` cria as tabelas (`usuarios`, `categorias`, `produtos`).
`--seed` popula com dados iniciais: um usuário admin e 4 categorias de exemplo.

### 4. Acessar

Abra o navegador em **http://localhost**

- **Landing pública:** http://localhost
- **Login:** http://localhost/login
  - Usuário: `admin@artesanal.local`
  - Senha: `senha1234`

Pronto, tá no ar.

---

## Comandos do dia-a-dia

Sempre rode pelo PowerShell **dentro da pasta do projeto**.

| O que você quer | Comando |
|---|---|
| Subir tudo (após desligar o PC, p. ex.) | `docker compose up -d` |
| Parar tudo (sem perder dados) | `docker compose down` |
| Ver se os containers estão de pé | `docker compose ps` |
| Ver logs de erro | `docker compose logs -f laravel.test` |
| Resetar o banco de dados zerando tudo | `docker compose exec laravel.test php artisan migrate:fresh --seed` |
| Limpar caches do Laravel (depois de editar código) | `docker compose exec laravel.test php artisan optimize:clear` |
| Compilar CSS/JS depois de mudar | `docker compose exec laravel.test npm run build` |
| Compilar CSS/JS em modo "watch" (recompila ao salvar) | `docker compose exec laravel.test npm run dev` |

---

## Problemas comuns

### "Site não carrega" / página em branco

1. Confere se o Docker Desktop tá aberto (baleinha verde).
2. Roda `docker compose ps` — devem aparecer dois containers com status `Up`.
3. Se não tiver nenhum, roda `docker compose up -d`.

### "Erro 500 na tela"

Geralmente é cache desatualizado depois de editar código. Rode:
```powershell
docker compose exec laravel.test php artisan optimize:clear
```

### "Página tá lenta na primeira vez que carrega"

Normal no Windows. O Docker lê os arquivos do projeto através de uma "ponte" entre Windows e Linux, e essa ponte é lenta na primeira leitura. Após 2-3 cliques, fica rápido.

### "Não consigo logar"

Verifique se rodou o `--seed`. Sem ele o usuário admin não existe. Pra criar do zero:
```powershell
docker compose exec laravel.test php artisan db:seed
```

### "Quero apagar tudo e começar do zero"

```powershell
docker compose down -v
docker compose up -d
docker compose exec laravel.test php artisan migrate --seed
```

A flag `-v` apaga o **volume** do MySQL (os dados).

---

## Estrutura de pastas (resumo do essencial)

```
laravel-project/
├── .docs/                  → documentação (essa pasta aqui)
├── app/
│   ├── Http/Controllers/   → recebem requisições e devolvem páginas
│   └── Models/             → representam tabelas do banco no código
├── database/
│   ├── migrations/         → "scripts" que criam as tabelas
│   └── seeders/            → "scripts" que populam dados iniciais
├── resources/
│   ├── views/              → páginas HTML (.blade.php)
│   ├── sass/               → estilos CSS (Bootstrap)
│   └── js/                 → JavaScript
├── routes/
│   └── web.php             → mapeia URLs → controllers
├── public/                 → arquivos públicos servidos direto
├── compose.yaml            → configuração dos containers Docker
└── .env                    → senhas, nome do banco, configs locais (NUNCA versionar)
```

Quem programa, mexe em `app/`, `resources/views/`, `routes/web.php` e `database/migrations/` na maior parte do tempo.
