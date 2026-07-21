# Guidelines

[![CI](https://github.com/xbot-my/guidelines/actions/workflows/ci.yml/badge.svg)](https://github.com/xbot-my/guidelines/actions/workflows/ci.yml)

Guidelines as AI skills, compatible with [Laravel Boost](https://laravel.com/docs/13.x/boost).

## Installation

### Laravel Boost

```bash
composer require xbot-my/guidelines --dev
php artisan boost:install
```

Select the guidelines from the list and they'll be installed automatically.

## CI

Each push and pull request is automatically checked:

- **Code style** — [Laravel Pint](https://github.com/laravel/pint) (`pint --test`) on PHP 8.4
- **Tests** — Pest test suite on PHP 8.3 and 8.4

## What's Included

| Skill                  | Description                                                           |
|------------------------|-----------------------------------------------------------------------|
| `xbot-laravel-php`     | Laravel & PHP coding conventions, PSR standards, control flow, naming |
| `xbot-version-control` | Git workflow conventions, repo/branch naming, commit messages         |
| `xbot-security`        | Application, database, and server security best practices             |

## Keeping Up to Date

### Composer

```bash
composer update xbot-my/guidelines
php artisan boost:update
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
