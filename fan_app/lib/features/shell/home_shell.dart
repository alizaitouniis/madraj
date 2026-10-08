import 'package:flutter/material.dart';

/// Bottom navigation: Matches, My tickets, My account.
/// Each tab is a placeholder until its Figma screen is built.
class HomeShell extends StatefulWidget {
  const HomeShell({super.key});

  @override
  State<HomeShell> createState() => _HomeShellState();
}

class _HomeShellState extends State<HomeShell> {
  static const _tabs = [
    (label: 'المباريات', icon: Icons.sports_soccer_outlined),
    (label: 'تذاكري', icon: Icons.confirmation_number_outlined),
    (label: 'حسابي', icon: Icons.person_outline),
  ];

  int _index = 0;

  @override
  Widget build(BuildContext context) {
    final tab = _tabs[_index];
    return Scaffold(
      appBar: AppBar(title: Text(tab.label)),
      body: Center(
        child: Text(
          tab.label,
          style: Theme.of(context).textTheme.headlineMedium,
        ),
      ),
      bottomNavigationBar: NavigationBar(
        selectedIndex: _index,
        onDestinationSelected: (i) => setState(() => _index = i),
        destinations: [
          for (final t in _tabs)
            NavigationDestination(icon: Icon(t.icon), label: t.label),
        ],
      ),
    );
  }
}
