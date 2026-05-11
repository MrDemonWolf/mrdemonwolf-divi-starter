# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## [1.0.3] - 2026-05-11

### Added

- Support for Divi 5 (theme now works on both Divi 4 and Divi 5)
- RankMath content-analysis fix for Divi 5 block content, auto-enabled when RankMath is active (`rank_math/researcher/post_content` filter pipes content through `the_content` so Divi 5 blocks render before analysis)
- `Requires at least`, `Requires PHP`, and `Tested up to` headers in `style.css`
- Child theme text domain loading on `after_setup_theme` for future translations
- CI/CD workflow (`.github/workflows/ci.yml`) running `php -l` (PHP 7.4–8.3), PHPCS with WordPress Coding Standards, PHPStan level 5 with `phpstan-wordpress`, and PHPUnit unit tests (PHP 7.4, 8.1, 8.3)
- `composer.json` with dev dependencies and convenience scripts (`lint`, `phpcs`, `phpstan`, `test`, `check`)
- `phpcs.xml.dist`, `phpstan.neon.dist`, `phpunit.xml.dist` configs
- Unit tests in `tests/unit/FunctionsTest.php` using WP_Mock + Brain Monkey (no WordPress install required)
- Recursion guard in the RankMath content filter
- `.gitignore` for `vendor/`, build caches, and OS junk

### Changed

- RankMath fix registration moved from `init` to `plugins_loaded` priority 20 (plugin constants guaranteed defined) and now uses a named function instead of a closure
- Parent stylesheet now enqueued with the parent theme's actual `Version` for cache control
- `mrdemonwolf_replace_howdy`: cast hour to `int`, clarified branches and inline-commented the late-night range
- `admin_bar_menu` priority lowered from `9992` to `100`
- Bumped `Tested up to` in readme.txt to 6.8

## [1.0.2] - 2026-02-20

### Changed

- Added ABSPATH guard to functions.php
- Unified function prefixes to `mrdemonwolf_`
- Fixed script handle from `grittolead-script` to `mrdemonwolf-script`
- Used `wp_date()` instead of `date()` for time-of-day greeting
- Fixed oEmbed filter: moved function declaration before registration, removed unused parameters
- Used `add_action` instead of `add_filter` for `admin_bar_menu` hook
- Added `Text Domain` to style.css header
- Removed debug `console.log` from script.js

## [1.0.1] - 2026-02-20

### Added

- Facebook-style console warning to deter social engineering attacks

## [1.0.0] - 2026-02-19

### Added

- Initial release of MrDemonWolf Divi Starter child theme
- Parent and child theme style enqueueing with cache-busting
- Child theme script enqueueing
- Custom admin bar greeting based on time of day
- Disabled author info from oEmbed response data
