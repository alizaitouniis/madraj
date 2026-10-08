# Madraj fan app

Flutter app for fans: matches, group booking (1 to 6 tickets), payment (WishMoney, card, cash at the stadium), QR tickets, account.
Screens follow the Figma "Fan app" page (390 wide). Colours, fonts and theme come from `packages/madraj_ui`.

```sh
flutter pub get
flutter run --dart-define=API_BASE_URL=http://10.0.2.2:8000/api
flutter test
```
