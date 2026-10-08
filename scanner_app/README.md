# Madraj scanner app

Flutter app for security staff at the stadium entrance: scan QR or look up by order code or phone, collect cash for reserved orders (USD or LBP), check fans in.
Screens follow the Figma "Security scanner app" page. Colours, fonts and theme come from `packages/madraj_ui`.

```sh
flutter pub get
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
flutter test
```
