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
