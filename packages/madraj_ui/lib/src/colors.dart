import 'package:flutter/painting.dart';

/// Colour tokens. Source of truth: Figma variables, collection "Madraj colors".
abstract final class MadrajColors {
  static const ink = Color(0xFF15201B);
  static const muted = Color(0xFF4D5A53);
  static const line = Color(0xFFD9DED9);
  static const surface = Color(0xFFF3F5F2);
  static const white = Color(0xFFFFFFFF);

  /// Primary green.
  static const cedar = Color(0xFF12452F);
  static const cedarSoft = Color(0xFFCFE3D7);
  static const tint = Color(0xFFE4EEE8);

  /// Main action buttons.
  static const red = Color(0xFFB8102A);

  static const amberBg = Color(0xFFFFF1D6);
  static const amberFg = Color(0xFF6E4300);
  static const amberBar = Color(0xFFC77A00);
  static const blueBg = Color(0xFFE3EDFB);
  static const blueFg = Color(0xFF1D4E89);
  static const greyBg = Color(0xFFECEEEC);
  static const greyFg = Color(0xFF3F4A44);
  static const redBg = Color(0xFFFBE4E7);
  static const redFg = Color(0xFF8C0C20);

  static const pitch = Color(0xFF2F7A4F);
  static const zoneMid = Color(0xFF5E9C7A);
  static const zoneLight = Color(0xFFB9CFC1);
  static const sidebar = Color(0xFF0F3A28);
}
