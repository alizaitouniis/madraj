# Madraj (مدرج): football ticketing platform

Project brief for Claude Code. This file is the summary of the planning and design chat. Read it fully before any task, and keep it updated when decisions change.

## What we are building

A ticketing platform for football matches at one stadium in Lebanon. Fans buy tickets in a mobile app, security staff scan tickets at the entrance, and each club manages its own matches from a web dashboard. The platform owner (super admin) manages team accounts and the stadium layout.

It is a multi-tenant SaaS: every team (club) has its own account. We launch with **one team only: Cedars FC (نادي الأرز)**. More teams are added later by the super admin.

## Parts of the system

| Part | Tech | Users |
|---|---|---|
| `backend/` | Laravel (latest stable), MySQL 8, REST API with Laravel Sanctum | everything talks to it |
| Admin dashboards | Laravel web, Filament recommended, Arabic RTL | team staff, platform super admin |
| `fan_app/` | Flutter | fans |
| `scanner_app/` | Flutter | security staff at the gates |

Outside services: WishMoney (merchant API, details still to get from Whish), a card payment gateway (to be chosen), an SMS provider (only for the sign-up verification code), Firebase Cloud Messaging (push notifications).

## Hard rules and decisions

- **Language: Arabic only, right-to-left everywhere.** No language switch. Use Western digits (17, $100). Currency shown in $.
- **Fonts:** Cairo (body, weights 400/500/600/700) and Noto Sans Arabic Condensed Bold (headings and big numbers).
- **Payment brand name is written exactly `WishMoney`** (Latin letters) everywhere, including inside Arabic sentences.
- **Payment methods:** WishMoney, debit/credit card, and **pay cash at the stadium**.
  - Cash at stadium means: the fan reserves online and gets QR codes immediately. The order is `reserved`. Security collects the cash at the entrance and checks the fan in. **Unpaid reservations are released back to sale at kick-off.** There is no delivery and no cash-on-delivery.
- **One stadium, made of zones.** No gates. Zones are drawn by the super admin in a drag-and-drop stadium builder (straight, corner, curved stands around a fixed pitch). Each zone stores name, seat capacity, colour, shape, x, y, width, height, rotation.
- Default zones: Main stand (المدرج الرئيسي) 600 seats $100, First tier (الدرجة الأولى) 900 seats $50, Regular North (المدرج الشمالي) 540 seats $10, Regular South (المدرج الجنوبي) 540 seats $10.
- Teams set **price, tickets for sale, max per order and on-sale switch per zone per match**. Capacity comes from the stadium.
- **Group booking:** 1 to 6 tickets per order, each ticket has its own person name and mobile and its own QR code.
- **Notifications: push only.** No SMS, WhatsApp or email alerts. Fan can toggle: tickets on sale, 1 day before, 2 hours before (match day), stadium opens, few tickets left.
- **SMS is used only for phone verification** (6-digit code) at sign-up and when the phone number changes.
- **No favourite teams** in the fan app (single team for now).
- **No subscription plans or commission screens** for now.
- The match editor does NOT have: "hold unpaid reservations until", "reminders to fans" card, or "ask for name and mobile on every ticket".
- Multi-tenancy: tenant tables carry `team_id` and are scoped automatically (global scope). A team never sees another team's data. Money goes to each team's own WishMoney merchant account or bank.

## Design (Figma, source of truth)

File: https://www.figma.com/design/BRICha6ApJCP3Ue1vnbMI6

Implement screens to match the Figma frames exactly. Open a frame by appending `?node-id=` with the id below (use `-` instead of `:` in URLs, e.g. `3-2`).

Pages: Fan app, Security scanner app, Team admin, Platform admin, Components.

**Fan app (390 wide)**
| Screen | Node |
|---|---|
| Login (first screen) | 38:97 |
| Register (step 1 of 2) | 38:139 |
| Verify phone, SMS code (step 2 of 2) | 38:199 |
| Account ready | 38:237 |
| Matches (home) | 3:2 |
| Match details | 3:180 |
| Choose tickets (zone map + group booking) | 4:49 |
| Payment, WishMoney selected | 4:164 |
| Payment, cash at stadium selected | 4:232 |
| My tickets (QR ticket + reserved order) | 4:314 |
| Stadium info | 6:74 |
| My account (حسابي) | 6:189 |
| Personal info (edit profile) | 40:151 |
| Change password | 40:197 |

Bottom nav tabs: المباريات (Matches), تذاكري (My tickets), حسابي (My account).
My account menu items without screens yet: طلباتي ومدفوعاتي (orders and payments), المساعدة والدعم (help), الشروط وسياسة الخصوصية (terms).

**Security scanner app**
| Screen | Node |
|---|---|
| Scan (camera + manual lookup + stats) | 7:100 |
| Result: valid and paid, check in | 7:170 |
| Result: reserved, collect cash (USD or LBP), check in | 7:212 |
| Result: refused (already used, expired, wrong match, refunded, unknown) | 7:263 |

**Team admin (web, 1440 wide)**
| Screen | Node |
|---|---|
| Overview | 9:102 |
| Match editor | 9:356 |
| Orders and payments | 10:224 |
| Match day: check-in and cash | 10:529 |
| Staff and roles | 10:769 |

**Platform admin (web)**
| Screen | Node |
|---|---|
| Team accounts (+ add team form) | 11:102 |
| Stadium builder (drag and drop zones) | 33:132 |

**Colour tokens** (also Figma variables, collection "Madraj colors")
ink #15201B, muted #4D5A53, line #D9DED9, surface #F3F5F2, white #FFFFFF, cedar (primary green) #12452F, cedar-soft #CFE3D7, tint #E4EEE8, red (main action buttons) #B8102A, amber-bg #FFF1D6, amber-fg #6E4300, amber-bar #C77A00, blue-bg #E3EDFB, blue-fg #1D4E89, grey-bg #ECEEEC, grey-fg #3F4A44, red-bg #FBE4E7, red-fg #8C0C20, pitch #2F7A4F, zone-mid #5E9C7A, zone-light #B9CFC1, sidebar #0F3A28.

## Roles and permissions (per team)

| Permission | Owner | Manager | Finance | Box office | Security |
|---|---|---|---|---|---|
| Create and edit matches | ✓ | ✓ | | | |
| Set prices and zones | ✓ | ✓ | | | |
| See orders and fans | ✓ | ✓ | ✓ | ✓ | |
| Refund and cancel | ✓ | ✓ | ✓ | | |
| Take cash at the stadium | ✓ | ✓ | ✓ | ✓ | ✓ |
| See payouts and reports | ✓ | | ✓ | | |
| Scan tickets at entry | ✓ | ✓ | | ✓ | ✓ |
| Invite staff | ✓ | | | | |

Platform super admin: manages team accounts and the stadium and zones (outside any team).

## Database (MySQL), first draft

- `users` (fans): id, full_name, phone (unique), email (unique), password, phone_verified_at, avatar, timestamps
- `otp_codes`: id, phone, code_hash, purpose (register, change_phone, reset_password), expires_at, attempts, consumed_at
- `platform_admins` (or a flag/role on an admin users table)
- `teams`: id, name, short_name, crest, colour, status (active, invited, paused), wishmoney_merchant_id, payment_methods (json), timestamps
- `staff` / `team_members`: id, team_id, name, email, password, role, last_active_at
- `stadiums`: id, name, address, map_link, opens_minutes_before, parking (json), allowed_items (json), forbidden_items (json), accessibility_note
- `zones`: id, stadium_id, name, capacity, colour, shape (straight, corner, curved), x, y, width, height, rotation, sort
- `matches`: id, team_id, opponent_name, opponent_crest, competition, kickoff_at, sales_open_at, sales_close_at, max_per_order (default 6), status (draft, scheduled, on_sale, sold_out, finished)
- `match_zones`: id, match_id, zone_id, price, tickets_for_sale, max_per_order, on_sale
- `orders`: id, code (MD-10482), team_id, match_id, user_id, zone_id, quantity, total, method (wishmoney, card, cash), status (pending_payment, paid, reserved, expired, refunded, cancelled), reserved_until, timestamps
- `tickets`: id, order_id, team_id, match_id, zone_id, holder_name, holder_phone, qr_token (unique, random), status (valid, used, void), checked_in_at, checked_in_by
- `payments`: id, order_id, method, amount, currency (USD, LBP), status, provider_ref, collected_by (staff id for cash), collected_at
- `device_tokens`: id, user_id or staff_id, token, platform
- `notification_settings`: user_id, on_sale, day_before, two_hours, stadium_opens, few_left (booleans)

Important logic:
- Lock zone availability when creating an order (database transaction plus row lock) so the last seats can't be sold twice.
- Scheduled job at kick-off: expire `reserved` cash orders that were not paid, release their seats, void their tickets.
- QR codes contain only a random token, never personal data. Scanner validates against the API.

## API (for the Flutter apps), first draft

Fan app:
- `POST /api/auth/register`, `POST /api/auth/otp/send`, `POST /api/auth/otp/verify`, `POST /api/auth/login`, `POST /api/auth/logout`
- `GET /api/me`, `PUT /api/me`, `PUT /api/me/password`, `PUT /api/me/notifications`, `POST /api/me/device-token`
- `GET /api/matches`, `GET /api/matches/{id}` (with zones, prices, availability), `GET /api/stadium`
- `POST /api/orders` (match, zone, attendees[], method), `GET /api/orders`, `GET /api/orders/{id}`
- `POST /api/payments/wishmoney/{order}` and `POST /api/payments/wishmoney/callback`, card equivalents
- `GET /api/tickets`, `GET /api/tickets/{id}/pdf`

Scanner app:
- `POST /api/scanner/login`, `GET /api/scanner/match-today`
- `POST /api/scanner/lookup` (qr_token or order code or phone)
- `POST /api/scanner/check-in`, `POST /api/scanner/collect-cash` (amount, currency)
- `GET /api/scanner/my-shift`

## Build order

1. Laravel project, migrations, models, seeders (Cedars FC, Cedar Park Stadium, 4 zones, 4 matches, staff users).
2. Auth API with OTP (SMS behind an interface with a fake driver).
3. Matches and stadium API.
4. Orders and booking with locking. Cash reservation and the kick-off expiry job.
5. Payments: WishMoney and card behind interfaces with fake drivers until real credentials arrive.
6. Tickets, QR, PDF.
7. Scanner API.
8. Push notifications and scheduled reminders.
9. Admin dashboards (team admin, then platform admin, then the stadium builder with a canvas library such as Konva.js).
10. Flutter fan app, screen by screen from Figma, connected to the API.
11. Flutter scanner app.
12. Staging server, real match-day test, store release.

## Working conventions

- One feature per session. Write tests for every API endpoint and run them before finishing.
- Commit after each working step.
- Flutter: Dio for HTTP, Riverpod for state, flutter_secure_storage for tokens, firebase_messaging for push, qr_flutter for QR, mobile_scanner in the scanner app. Set the app to RTL (`Directionality` / locale `ar`).
- Placeholders still unknown: service fee, parking prices, stadium street address, accessibility phone number, WishMoney API details, card gateway, SMS provider.

## Repository layout

```
backend/              Laravel 13 (PHP 8.3), REST API + Sanctum. Admin dashboards (Filament) come in build step 9.
fan_app/              Flutter app for fans (package madraj_fan, bundle id lb.madraj.madraj_fan)
scanner_app/          Flutter app for security staff (package madraj_scanner, bundle id lb.madraj.madraj_scanner)
packages/madraj_ui/   Shared Flutter package: colour tokens, Cairo + Noto Sans Arabic Condensed fonts, theme, MadrajApp (Arabic RTL)
docker-compose.yml    Local MySQL 8.4 for the backend
.github/workflows/    CI: backend (Pint + PHPUnit on MySQL), flutter (format, analyze, test for all three Dart projects)
```

- Colours and fonts live only in `packages/madraj_ui`. Apps never hard-code a hex colour or font family; add a token there first.
- Flutter apps read the API URL from `--dart-define=API_BASE_URL=...` (default `http://10.0.2.2:8000/api`, the Android emulator's view of the host).
- Outside services are configured in `backend/config/services.php` with `*_DRIVER=fake` in `.env.example` until real credentials exist.
- `firebase_messaging` is not added yet: it needs the Firebase project files (`google-services.json`, `GoogleService-Info.plist`). Add it in build step 8.

## Commands

Backend (from `backend/`):
- First run: `docker compose up -d` (repo root), then `composer install`, `cp .env.example .env`, `php artisan key:generate`, `php artisan migrate`
- Serve: `php artisan serve`
- Tests: `php artisan test` (SQLite in memory by default; CI runs them on MySQL)
- Style: `vendor/bin/pint` (CI runs `pint --test`)

Flutter (from `fan_app/`, `scanner_app/` or `packages/madraj_ui/`), Flutter 3.47 stable:
- `flutter pub get`, `flutter run`, `flutter test`, `flutter analyze`, `dart format lib test`

## Existing code

The repository is scaffolded (build order step 0): Laravel with Sanctum and a `GET /api/health` endpoint, the shared UI package, and both Flutter apps opening on an RTL placeholder (fan app with the three bottom tabs, scanner app with the scan screen). Next step is build step 1.

A first English Flutter prototype of the fan app exists (from the planning chat, `madraj_flutter.zip`), not in this repository. It uses dummy data and an older English, left-to-right design. It can be used as a starting point but must be converted to Arabic RTL and to the current Figma screens.
