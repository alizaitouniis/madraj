import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:madraj_scanner/app.dart';

void main() {
  testWidgets('opens on the scan screen in RTL', (tester) async {
    await tester.pumpWidget(const ProviderScope(child: App()));

    final scaffold = tester.element(find.byType(Scaffold));
    expect(Directionality.of(scaffold), TextDirection.rtl);
    expect(find.text('مسح التذاكر'), findsOneWidget);
  });
}
