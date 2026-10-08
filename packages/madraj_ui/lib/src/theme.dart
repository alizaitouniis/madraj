import 'package:flutter/material.dart';

import 'colors.dart';
import 'fonts.dart';

/// Material 3 theme built from the Madraj tokens.
ThemeData madrajTheme() {
  const scheme = ColorScheme.light(
    primary: MadrajColors.cedar,
    onPrimary: MadrajColors.white,
    primaryContainer: MadrajColors.cedarSoft,
    onPrimaryContainer: MadrajColors.cedar,
    secondary: MadrajColors.red,
    onSecondary: MadrajColors.white,
    error: MadrajColors.redFg,
    errorContainer: MadrajColors.redBg,
    surface: MadrajColors.white,
    onSurface: MadrajColors.ink,
    onSurfaceVariant: MadrajColors.muted,
    surfaceContainerLowest: MadrajColors.white,
    surfaceContainerLow: MadrajColors.surface,
    outline: MadrajColors.line,
    outlineVariant: MadrajColors.line,
  );

  final base = ThemeData(
    useMaterial3: true,
    colorScheme: scheme,
    fontFamily: MadrajFonts.body,
    scaffoldBackgroundColor: MadrajColors.surface,
  );

  const heading = TextStyle(
    fontFamily: MadrajFonts.heading,
    fontWeight: FontWeight.w700,
    color: MadrajColors.ink,
  );

  return base.copyWith(
    textTheme: base.textTheme
        .apply(bodyColor: MadrajColors.ink, displayColor: MadrajColors.ink)
        .copyWith(
          displayLarge: base.textTheme.displayLarge?.merge(heading),
          displayMedium: base.textTheme.displayMedium?.merge(heading),
          displaySmall: base.textTheme.displaySmall?.merge(heading),
          headlineLarge: base.textTheme.headlineLarge?.merge(heading),
          headlineMedium: base.textTheme.headlineMedium?.merge(heading),
          headlineSmall: base.textTheme.headlineSmall?.merge(heading),
        ),
    appBarTheme: const AppBarTheme(
      backgroundColor: MadrajColors.white,
      foregroundColor: MadrajColors.ink,
      elevation: 0,
      centerTitle: true,
    ),
    dividerTheme: const DividerThemeData(color: MadrajColors.line),
    filledButtonTheme: FilledButtonThemeData(
      style: FilledButton.styleFrom(
        backgroundColor: MadrajColors.red,
        foregroundColor: MadrajColors.white,
        minimumSize: const Size.fromHeight(52),
        textStyle: const TextStyle(
          fontFamily: MadrajFonts.body,
          fontWeight: FontWeight.w700,
          fontSize: 16,
        ),
      ),
    ),
    navigationBarTheme: const NavigationBarThemeData(
      backgroundColor: MadrajColors.white,
      indicatorColor: MadrajColors.tint,
    ),
  );
}
