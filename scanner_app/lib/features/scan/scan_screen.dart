import 'package:flutter/material.dart';

/// Placeholder for the Scan screen (Figma 7:100): camera, manual lookup, stats.
class ScanScreen extends StatelessWidget {
  const ScanScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('مسح التذاكر')),
      body: Center(
        child: Text(
          'وجّه الكاميرا نحو رمز التذكرة',
          style: Theme.of(context).textTheme.titleMedium,
        ),
      ),
    );
  }
}
