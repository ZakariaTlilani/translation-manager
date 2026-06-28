# Translation Manager

This package uses `spatie/laravel-translation-loader`, Make sure your migration is done correctly.
This package uses phpfilament v5, make sure you have php 8.2 or greater.

## Installation

You can install the package via composer:

```bash
composer require zakariatlilani/translation-manager
```

### Plugin Configuration

```php
use ZakariaTlilani\TranslationManager\TranslationManagerPlugin;

TranslationManagerPlugin::make()
    ->availableLocales([
        ['code' => 'en', 'name' => 'English', 'flag' => 'gb'],
        ['code' => 'fr', 'name' => 'Français', 'flag' => 'fr'],
    ])
    ->languageSwitcher(true)
    ->languageSwitcherRenderHook('panels::user-menu.before')
    ->navigationGroup('Settings')
    ->navigationIcon('heroicon-o-globe-alt')
    ->showFlags(true)
    ->disableKeyAndGroupEditing(false)
    ->dontRegisterNavigationOnPanelIds(['guest'])
    ->prependDirectoryPathToGroupName(false)
```

#### Available Configuration Methods

- `availableLocales(array $locales)` - Set available application locales
- `disableKeyAndGroupEditing(bool $disable = true)` - Control key/group editing
- `languageSwitcher(bool $enable = true)` - Enable/disable language switcher
- `languageSwitcherRenderHook(string $hook)` - Set render hook for language switcher
- `navigationGroupTranslationKey(?string $key)` - Set navigation group translation key
- `navigationGroup(?string $group)` - Set navigation group
- `navigationIcon(mixed $icon)` - Set navigation icon (supports `false` to disable)
- `dontRegisterNavigationOnPanelIds(array $panelIds)` - Exclude panels from navigation
- `showFlags(bool $show = true)` - Show flags in language switcher
- `prependDirectoryPathToGroupName(bool $prepend = true)` - Control group naming

### Config File

You can use the following command to publish the configuration file:

```bash
php artisan vendor:publish --tag=translation-manager-config
```

## Authorization

By default, the translation manager cannot be used by anyone.
You need to define the following gate in your `AppServiceProvider` boot method:

```php
// app/Providers/AppServiceProvider.php

use Illuminate\Support\Facades\Gate;

/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    Gate::define('use-translation-manager', function (?User $user) {

        return $user !== null && $user->hasRole('admin');
    });
}
```

#### `available_locales`

Determines which locales your application supports. For example:

```php
'available_locales' => [
    ['code' => 'en', 'name' => 'English', 'flag' => 'gb'],
    ['code' => 'ar', 'name' => 'Arabic', 'flag' => 'sa'],
]
```

#### `language_switcher`

Enable or disable the language switcher feature. This allows users to switch their language - disable if you have your own implementation.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
