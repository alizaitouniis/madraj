import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:madraj_ui/madraj_ui.dart';

void main() {
  testWidgets('MadrajApp lays out right to left in Arabic', (tester) async {
    await tester.pumpWidget(
      const MadrajApp(
        title: 'مدرج',
        home: Scaffold(body: Text('مرحبا')),
      ),
    );

    final context = tester.element(find.text('مرحبا'));
    expect(Directionality.of(context), TextDirection.rtl);
    expect(Localizations.localeOf(context), madrajLocale);
  });

  test('theme uses the Madraj tokens', () {
    final theme = madrajTheme();
    expect(theme.colorScheme.primary, MadrajColors.cedar);
    expect(theme.scaffoldBackgroundColor, MadrajColors.surface);
  });
}
