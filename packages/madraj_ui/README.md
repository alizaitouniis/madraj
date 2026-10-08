# madraj_ui

Shared design layer for `fan_app` and `scanner_app`:

- `MadrajColors`: the colour tokens from Figma (collection "Madraj colors").
- `MadrajFonts`: Cairo (body, 400/500/600/700) and Noto Sans Arabic Condensed Bold (headings, big numbers).
- `madrajTheme()`: Material 3 theme built from the tokens.
- `MadrajApp`: a `MaterialApp` locked to Arabic, right to left.

Fonts are static instances made from the Google Fonts variable fonts with
`fonttools varLib.instancer` (Cairo `wght` 400 to 700, `slnt=0`; Noto Sans Arabic `wght=700`, `wdth=75`).
Licences are in `fonts/`.
