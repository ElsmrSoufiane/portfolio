---
paths:
  - 'resources/views/**'
---

# Views

## Localize all displayed strings via __() + lang JSON files
All user-facing strings rendered in Blade views and Filament pages/actions must be wrapped in __(). Register every key in lang/en.json (source), lang/fr.json, and lang/ar.json — keys are full English strings. Filament automatically passes derived field labels (Title, Duration, etc.) through __(), so those words must also exist in the JSON files to translate in FR/AR.
