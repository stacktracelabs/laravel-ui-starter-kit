<laravel-boost-guidelines>
=== .ai/agent-workflow rules ===

# Agent Workflow

- Never edit `AGENTS.md` directly. Update the source guidelines in `.ai/guidelines` and regenerate `AGENTS.md` with `php artisan boost:update --no-interaction`.
- Do not search the `@inertiajs/vue3` documentation for standalone Vue APIs or concepts. Use those docs only for Inertia's Vue integration, and consult the official Vue documentation for Vue behavior such as component options, reactivity, and Single-File Components.

=== .ai/application-architecture rules ===

# Application Architecture

- Place stateful application coordinators in `app/Managers`.
- Place discrete business operations in `app/Actions`.
- Keep reusable actions transaction-agnostic. The caller or a higher-level workflow that understands the complete atomic operation must define the database transaction boundary so multiple actions can be composed within one transaction.
- Keep reusable actions independent from transport and caller-specific concerns such as HTTP requests and responses, redirects, `abort()`, sessions, and toasts. Actions should accept explicit inputs, return useful results, and throw exceptions for callers to translate or allow to fail according to their context.
- Coordinate non-database side effects outside the transaction after a successful commit unless they explicitly support after-commit execution.
- Reserve `app/Support` for generic framework glue and utilities rather than domain or application services.
- Larger cohesive features may move into `app/Features/{FeatureName}` as the application grows.
- Do not append an `.index` suffix to index route names. Name them after the resource itself, such as `users` or `payments`.
- In route files, import the nearest shared controller namespace instead of each controller class. Reference controllers through that namespace, such as `Controllers\UserController::class` or `Settings\UserController::class`, to keep import lists compact as routes grow.
- Do not declare return types on controller methods.
- Controllers may define only `__construct`, `index`, `create`, `store`, `edit`, `update`, and `destroy`. A single-responsibility controller may instead define `__invoke`. Model other operations as CRUD actions on a suitably named controller.
- Keep simple orchestration directly inside each controller action so its context can be read from start to finish. Prefer small, intentional duplication over extracting one-line or first-use helpers that force readers to jump between methods; extract only genuinely complex or cohesive business logic.
- Create Form Requests intentionally when substantial validation, authorization, or input preparation would obscure the controller's business flow, or when complex rules need reuse. Keep small validation and authorization inline when that makes the action easier to understand, and prefer simple duplication over an unnecessary cross-class jump; balance both approaches rather than applying Form Requests by default.
- Validate every user-supplied input before using it, regardless of its perceived importance. After validation, prefer reading straightforward values through request accessors such as `input()`, `integer()`, `boolean()`, and `date()` when it is easy to verify that the same input was validated; use `validated()` or `safe()` when complex, nested, or multi-field data makes that relationship clearer and safer.
- Place explicit frontend serialization contracts in `app/ViewModels` and implement Inertia's first-party `ProvidesInertiaProperty` or `ProvidesInertiaProperties` interfaces.
- Do not pass Eloquent models directly to the frontend. Return explicitly selected fields and name every output key deliberately.
- Use camelCase for every key emitted by view models and for the corresponding frontend properties and types.

=== .ai/backend-code-style rules ===

# Backend Code Style

- Prefer `protected` visibility over `private` for application class state and internal methods.
- Always declare an explicit type on class constants, such as `protected const string SESSION_KEY = 'team_id';`.
- Business classes should include concise property and method PHPDoc blocks that briefly describe intent.
- Business class declarations, constructors, and constructor-promoted properties do not require PHPDoc blocks.
- Do not add redundant `@param` or `@return` tags when native parameter and return types already describe the signature.
- Keep ordinary method parameter lists on one line when they contain only a sensible number of arguments and remain readable. Prefer a slightly longer single-line signature over splitting a short parameter list; use multiple lines only when the arguments are genuinely numerous or long. Constructors are the exception and should usually list dependencies on separate lines.
- Do not create temporary variables that are used only once unless naming the value materially improves readability. Inline one-off expressions when the resulting code remains clear.
- On PHP 8.4 and newer, access members on newly instantiated objects directly, such as `new User()->getQualifiedKeyName()`. Do not wrap the `new` expression in parentheses.
- Avoid explicit scalar casts when PHP return types, typed properties, or framework and model casts already provide the intended type. Rely on PHP's native type coercion and runtime value types; cast only to intentionally change representation or enforce a critical type boundary.
- Do not define default column values in migrations unless there is no viable alternative. Set defaults explicitly in application code so business behavior remains visible to developers.
- Never define `$fillable` or use the `#[Fillable]` attribute on Eloquent models. Disable mass-assignment guarding with `protected $guarded = false` and only pass explicitly constructed attribute arrays to Eloquent.
- Do not use `forceFill()`. Use `fill()` with explicitly selected attributes instead.
- Access Eloquent model attributes through dynamic properties, such as `$model->name` or `$model->pivot->role`. Do not call `getAttribute()` when reading a normal model attribute.
- Prefer Eloquent relationship APIs such as `make()`, `save()`, `associate()`, and `dissociate()` over assigning foreign-key attributes directly when the relationship is available and the result remains clear. Treat this as a preference rather than a strict rule; direct foreign keys remain appropriate for bulk operations, migrations, or cases where relationship APIs reduce clarity.
- Pass backed enum cases directly to Eloquent and query builder predicates. Do not unwrap them with `->value`; Laravel converts enum bindings automatically.
- Order Eloquent model members as follows: traits, constants, properties, `casts()`, relationships, scopes, attributes and accessors, then all remaining methods.
- Do not add comments or PHPDoc blocks to model constants, properties, `casts()` methods, or relationship methods.
- Do not define default model attribute values through the `$attributes` property. Supply defaults explicitly at each model creation point, including factories.
- Use `@property-read` for relationship properties documented in model class PHPDoc blocks because dynamic relationship properties are read-only.

=== .ai/frontend-code-style rules ===

# Frontend Code Style

- Do not disable controls merely to prevent harmless repeated actions because disabled states communicate unavailability and usually change the control's visual treatment. When repetition is safe, keep the action available; when a selected or current option should do nothing, remove its action so it behaves as a no-op without appearing disabled.
- Use Inertia prefetching intentionally rather than by default. Do not add `prefetch` unless there is a demonstrated navigation benefit that justifies caching the page response; prefetched props can become stale when session, user, workspace, or other mutable state changes. When prefetching is warranted, define an appropriate cache lifetime and invalidation strategy.

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.5. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project keeps committed, area-grouped rules in `.ai/rules` (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== inertia-laravel/core rules ===

# Inertia

- Inertia creates fully client-side rendered SPAs without modern SPA complexity, leveraging existing server-side patterns.
- Components live in `resources/js/Pages` (unless specified in `vite.config.js`). Use `Inertia::render()` for server-side routing instead of Blade views.
- ALWAYS use `search-docs` tool for version-specific Inertia documentation and updated code examples.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

# Inertia v3

- Use all Inertia features from v1, v2, and v3. Check the documentation before making changes to ensure the correct approach.
- New v3 features: standalone HTTP requests (`useHttp` hook), optimistic updates with automatic rollback, layout props (`useLayoutProps` hook), instant visits, simplified SSR via `@inertiajs/vite` plugin, custom exception handling for error pages.
- Carried over from v2: deferred props, infinite scroll, merging props, polling, prefetching, once props, flash data.
- When using deferred props, add an empty state with a pulsing or animated skeleton.
- Axios has been removed. Use the built-in XHR client with interceptors, or install Axios separately if needed.
- `Inertia::lazy()` / `LazyProp` has been removed. Use `Inertia::optional()` instead.
- Prop types (`Inertia::optional()`, `Inertia::defer()`, `Inertia::merge()`) work inside nested arrays with dot-notation paths.
- SSR works automatically in Vite dev mode with `@inertiajs/vite` - no separate Node.js server needed during development.
- Event renames: `invalid` is now `httpException`, `exception` is now `networkError`.
- `router.cancel()` replaced by `router.cancelAll()`.
- The `future` configuration namespace has been removed - all v2 future options are now always enabled.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== inertia-vue/core rules ===

# Inertia + Vue

Vue components must have a single root element.
- IMPORTANT: Activate `inertia-vue-development` when working with Inertia Vue client-side patterns.

</laravel-boost-guidelines>
