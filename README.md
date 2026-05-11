# MrDemonWolf Divi Starter Theme

A minimal Divi child theme for custom development by MrDemonWolf, Inc.

## Overview

A clean foundation for building custom websites with the Divi theme.

## Prerequisites

- WordPress 5.0+
- Divi Theme — Divi 4 or Divi 5 (installed and activated)
- PHP 7.4+

## Get Divi

[**Download Divi Now!**](https://mrdwolf.net/elegantthemes)

## Installation

1.  Download
2.  Upload (Appearance > Themes > Add New)
3.  Activate

## Usage

Customize the child theme to meet your needs.

### Customization

- `style.css`: Custom CSS
- `functions.php`: Custom PHP
- Templates: Override Divi templates
- Divi Builder: Use as normal

### RankMath Integration

If [Rank Math SEO](https://rankmath.com/) is active, the theme automatically registers a `rank_math/researcher/post_content` filter that pipes Divi 5 block content through `the_content` so RankMath's content analysis reports accurate word counts and keyword usage on Divi 5 posts. No configuration required — it only activates when RankMath is detected.

## Support

See the Divi documentation or open an issue.

## Development

Dev dependencies (PHPCS+WPCS, PHPStan, PHPUnit, WP_Mock) are managed with Composer.

```bash
composer install
composer lint       # php -l on all PHP files
composer phpcs      # WordPress Coding Standards
composer phpcbf     # Auto-fix what PHPCS can fix
composer phpstan    # Static analysis (level 5, with WP stubs)
composer test       # PHPUnit unit tests
composer check      # Run everything
```

CI runs all four on every push/PR via [`.github/workflows/ci.yml`](.github/workflows/ci.yml) across PHP 7.4, 8.0, 8.1, 8.2, 8.3.

## Contributing

Pull requests are welcome.

## License

GNU GPL v2 or later.

## Credits

MrDemonWolf, Inc. - [https://mrdemonwolf.com](https://www.mrdemonwolf.com)
