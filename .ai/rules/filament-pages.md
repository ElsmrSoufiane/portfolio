---
paths:
  - tests/Feature/Filament/Pages/AdminChatTest.php
---

# Filament Pages

## pdo_sqlite missing: tests can't run here
The phpunit.xml uses sqlite :memory: but the PHP runtime lacks the pdo_sqlite extension and the DB user lacks permission to create a MySQL test DB, so `php artisan test` cannot execute in this environment. Verify changes via php -l, blade compile (BladeCompiler->compileString in tinker), and pint instead of running PHPUnit.
