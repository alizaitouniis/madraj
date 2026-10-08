# Backend notes

The project brief is in the root `CLAUDE.md`; read it first.

- Laravel 13, PHP 8.3. API routes in `routes/api.php`, authenticated with Sanctum bearer tokens.
- Every API endpoint gets a feature test in `tests/Feature`. Run `php artisan test` and `vendor/bin/pint --test` before finishing.
- Tests use SQLite in memory locally (see `phpunit.xml`); CI runs them on MySQL 8. Avoid SQL that only one of them understands.
- Tenant models carry `team_id` and use a global scope; never query tenant data without it.
- Outside services (SMS, WishMoney, card, FCM) are interfaces bound in a service provider, with a `fake` driver chosen by `*_DRIVER` in `.env`. Config keys are in `config/services.php`.
- API messages returned to the apps are in Arabic (`APP_LOCALE=ar`).
