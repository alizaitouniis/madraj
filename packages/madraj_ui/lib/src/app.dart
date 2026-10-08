import 'package:flutter/material.dart';
import 'package:flutter_localizations/flutter_localizations.dart';

import 'theme.dart';

/// Arabic only, right to left. There is no language switch.
const madrajLocale = Locale('ar');

/// A [MaterialApp] locked to Arabic RTL with the Madraj theme.
class MadrajApp extends StatelessWidget {
  const MadrajApp({super.key, required this.title, required this.home});

  final String title;
  final Widget home;

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: title,
      debugShowCheckedModeBanner: false,
      theme: madrajTheme(),
      locale: madrajLocale,
      supportedLocales: const [madrajLocale],
      localizationsDelegates: GlobalMaterialLocalizations.delegates,
      home: home,
    );
  }
}
