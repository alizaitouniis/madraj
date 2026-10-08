# Madraj (مدرج)

Football ticketing platform for one stadium in Lebanon. Fans buy tickets in a mobile app, security staff scan them at the entrance, and each club runs its own matches from a web dashboard. Arabic only, right to left.

The full project brief (decisions, database, API, build order) is in [CLAUDE.md](CLAUDE.md). Design source of truth: [Figma](https://www.figma.com/design/BRICha6ApJCP3Ue1vnbMI6).

| Folder | What | Stack |
|---|---|---|
| [`backend/`](backend) | API, team admin and platform admin | Laravel 13, MySQL 8, Sanctum |
| [`fan_app/`](fan_app) | Fan mobile app | Flutter |
| [`scanner_app/`](scanner_app) | Security scanner app | Flutter |
| [`packages/madraj_ui/`](packages/madraj_ui) | Shared colours, fonts and theme for both apps | Flutter package |

## Getting started

Requirements: PHP 8.3+, Composer, Docker (for MySQL), Flutter 3.47 stable.

```sh
# Database
docker compose up -d

# Backend
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve          # http://localhost:8000/api/health

# Fan app (Android emulator reaches the backend at 10.0.2.2)
cd ../fan_app
flutter pub get
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
```

The scanner app runs the same way from `scanner_app/`.

## Tests

```sh
cd backend && php artisan test && vendor/bin/pint --test
cd fan_app && flutter analyze && flutter test        # same for scanner_app and packages/madraj_ui
```

CI runs all of these on every push and pull request.
