/// Build-time configuration. Override with
/// `flutter run --dart-define=API_BASE_URL=https://api.example.com/api`.
abstract final class AppConfig {
  /// Android emulator reaches the host machine at 10.0.2.2.
  static const apiBaseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: 'http://10.0.2.2:8000/api',
  );
}
