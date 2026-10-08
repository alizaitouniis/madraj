import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:madraj_fan/app.dart';

void main() {
  testWidgets('opens on Matches in RTL and switches tabs', (tester) async {
    await tester.pumpWidget(const ProviderScope(child: App()));

    final scaffold = tester.element(find.byType(Scaffold));
    expect(Directionality.of(scaffold), TextDirection.rtl);
    expect(find.text('المباريات'), findsWidgets);

    await tester.tap(find.text('تذاكري'));
    await tester.pumpAndSettle();
    expect(find.widgetWithText(AppBar, 'تذاكري'), findsOneWidget);
  });
}
