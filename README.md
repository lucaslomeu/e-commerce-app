# E-commerce Fullstack (Laravel + Nuxt)

## Descrição do Projeto

Projeto de E-commerce desenvolvido em duas partes:

- Backend (Laravel 11+): API REST para produtos, importação assíncrona de dados da Fake Store API usando filas (Redis + Horizon), arquitetura desacoplada (service, repository, request validation).
- Frontend (Nuxt 3 SPA): Interface minimalista e responsiva para listagem de produtos, página de detalhes e carrinho de compras com persistência local (Pinia + LocalStorage).

## Funcionalidades

- CRUD + filtros para produtos
- Importação em background (fila)
- Frontend SPA com filtros, detalhes e carrinho persistente

## Stack

- Laravel 11, Redis, PostgreSQL, Horizon
- Nuxt 3, Pinia, CSS
- Docker Compose

## Instalação e Execução

```bash
git clone https://github.com/lucaslomeu/e-commerce-app.git
cd e-commerce-app
docker-compose up --build
```

- Backend (API): http://localhost:8000
- Frontend (SPA): http://localhost:3000
- Horizon: http://localhost:8000/horizon

## Exemplos de Uso da API

- **Listar produtos:**  
  `GET /api/products`
- **Filtrar por nome/categoria:**  
  `/api/products?name=Produto&category=cat1`
- **Buscar por ID:**  
  `/api/products/1`
- **Criar/Editar/Deletar:**  
  Use os métodos HTTP `POST`, `PUT`, `DELETE` em `/api/products`.

### Importação de Produtos (Fake Store API) e Gerenciamento de Filas

- Importar todos:

```bash
docker-compose exec app php artisan products:import
```

- Importar produto específico:

```bash
docker-compose exec app php artisan products:import --id=1
```

> O comando dispara jobs na fila Redis, processados pelo worker Horizon: [http://localhost:8000/horizon](http://localhost:8000/horizon)

### Gerenciamento de Filas (Redis + Horizon)

- Ver o painel do Horizon:
  > http://localhost:8000/horizon
- Rodar o Worker:

```bash
docker-compose exec app php artisan horizon
```

- Parar o Horizon:

```bash
docker-compose exec app php artisan horizon:terminate
```

- Limpar fila:

```bash
docker-compose exec app php artisan queue:flush
```

- Limpar jobs falhos:

```bash
docker-compose exec app php artisan queue:forget all
```
