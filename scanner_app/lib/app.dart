import 'package:flutter/material.dart';
import 'package:madraj_ui/madraj_ui.dart';

import 'features/scan/scan_screen.dart';

class App extends StatelessWidget {
  const App({super.key});

  @override
  Widget build(BuildContext context) {
    return const MadrajApp(title: 'مدرج - الأمن', home: ScanScreen());
  }
}
