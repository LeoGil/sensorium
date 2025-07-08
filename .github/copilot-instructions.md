# Copilot Instructions for Sensorium Project

Este arquivo orienta o GitHub Copilot a seguir as convenções e padrões de código do **Sensorium**, usando como exemplo detalhado o **CRUD de Brand** que você já implementou. Embora o exemplo principal seja a Brand, estas instruções aplicam-se a todo o escopo do seu aplicativo — rotas, controllers, validações, policies, Inertia/Vue e muito mais.

---

## 1. Objetivo Geral

* **Padronizar sugestões** do Copilot em todo o projeto Sensorium.
* **Exemplificar** com o CRUD de Brand, mas cobrir também: outros modelos, controllers, validações, uploads, autorizações, Inertia/Vue, estruturas de pastas e rotas.

## 2. Checklist Rápido para Novo CRUD

- [ ] Criar Model em `app/Models/`
- [ ] Criar Migration em `database/migrations/`
- [ ] Criar Requests em `app/Http/Requests/Entity/`
- [ ] Criar Policy em `app/Policies/`
- [ ] Criar Controller em `app/Http/Controllers/`
- [ ] Registrar rota em `routes/web.php`
- [ ] Criar interface TypeScript em `resources/js/types/index.d.ts`
- [ ] Criar componentes Vue em `resources/js/components/entity/`
- [ ] Criar página principal em `resources/js/pages/entity/Index.vue`
- [ ] Garantir ownership e policies
- [ ] Testar CRUD completo

---

## 3. Exemplo de CRUD de Brand (Padrão Sensorium)

> **Caminhos no repositório**:
>
> * Modelo: `app/Models/Brand.php`
> * Migration: `database/migrations/2025_XX_XX_create_brands_table.php`
> * Requests: `app/Http/Requests/Brand/StoreBrandRequest.php`, `UpdateBrandRequest.php`
> * Controller: `app/Http/Controllers/BrandController.php`
> * Policy: `app/Policies/BrandPolicy.php`
> * Views Vue: `resources/js/Pages/Brands/` (Index.vue, Create.vue, Edit.vue, Show.vue)
> * Rotas: `routes/web.php` → `Route::resource('brands', BrandController::class)`

1. **Modelo**: use `$fillable`, relacionamentos Eloquent com `belongsTo`/`hasMany`.
2. **Requests**: `authorize() { return auth()->check(); }` e regras de validação consistentes (`required|string|max:255`, `unique:table,column`, `image|max:2048`).
3. **Controller**: `authorizeResource(Brand::class, 'brand')`, métodos RESTful filtrando por `auth()->id()`, upload de arquivos e redirecionamentos Inertia.
4. **Policy**: métodos `viewAny`, `view`, `create`, `update`, `delete`, registrados em `AuthServiceProvider`.
5. **Rotas**: `middleware(['auth','verified'])->resource(...)` com `->names('brands')`.
6. **Vue**: pages em `resources/js/Pages/<ModelPlural>/`, importações `Head`, `Link`, `useForm`, e layout `AppLayout.vue`.

Copilot deve espelhar este fluxo para quaisquer outros recursos (ex: `Product`, `Category`, `User` etc.).

---

## 4. Adaptação para Outros Módulos

* **Novo Model**: `php artisan make:model Nome -m -f` sugerido automaticamente.
* **Requests**: scaffolded com regras semelhantes (`StoreXRequest`, `UpdateXRequest`).
* **Controller**: use `authorizeResource(Nome::class, 'nome')` e siga a mesma assinatura de métodos.
* **Policy**: `php artisan make:policy NomePolicy --model=Nome` e registre.
* **Routes**: `Route::resource('nomes', NomeController::class)` dentro do grupo de middleware.
* **Views Vue**: crie pasta `resources/js/Pages/Nomes/` com `Index.vue`, `Create.vue`, `Edit.vue`, `Show.vue` mantendo a estrutura de slots e componentes Inertia.

Copilot deve mapear cada passo do CRUD de Brand para novas entidades.

---

## 5. Convenções Gerais de Código

* **Namespaces e Pastas**: `app/Models`, `app/Http/Controllers`, `app/Http/Requests/<Entity>`, `app/Policies`.
* **Nomes**: Model singular PascalCase; Controller sufixo `Controller`; Requests `StoreXRequest`, `UpdateXRequest`; Policies `XPolicy`.
* **Métodos RESTful**: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.
* **Validação e Autorização**: sempre usar Form Requests e Policies/Gates.
* **Inertia + Vue**: usar `Inertia::render('Pages/Entity/Action')`, `useForm()` e `Link` para navegação.

---

## 6. Mensagens de Erro e Feedback

- Mensagens de validação devem ser claras e amigáveis.
- Use toasts para feedback de sucesso/erro no frontend.

---

## 7. FAQ

**Quando criar o método/rota `show`?**  
> Apenas se houver necessidade de exibir detalhes de uma entidade em página separada.

**Como lidar com relacionamentos?**  
> Use Eloquent (`belongsTo`, `hasMany`) e inclua os relacionamentos necessários no Model e nas queries do Controller.

**Como garantir que só o dono edite/exclua?**  
> Sempre implemente e use policies com checagem de `user_id`.

---

## 8. Exemplos de Snippets para Copilot

* **Gerar Model com Migration e Factory**:

  ```bash
  php artisan make:model {{Entity}} -m -f
  ```
* **Criar Requests**:

  ```bash
  php artisan make:request {{Entity}}/Store{{Entity}}Request
  php artisan make:request {{Entity}}/Update{{Entity}}Request
  ```
* **Criar Controller com Resource Methods**:

  ```bash
  php artisan make:controller {{Entity}}Controller --resource --model={{Entity}}
  ```
* **Criar Policy**:

  ```bash
  php artisan make:policy {{Entity}}Policy --model={{Entity}}
  ```
* **Registrar Rota**:

  ```php
  Route::middleware(['auth','verified'])
       ->resource('{{entities}}', {{Entity}}Controller::class)
       ->names('{{entities}}');
  ```

Copilot deve substituir `{{Entity}}` e `{{entities}}` conforme o contexto.

---

*Estas instruções garantem que o Copilot entenda o padrão geral do Sensorium e aplique o exemplo de Brand a qualquer outro CRUD que você criar.*
