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

### Changed

- Parent stylesheet now enqueued with the parent theme's actual `Version` for cache control
- `mrdemonwolf_replace_howdy`: cast hour to `int`, rewrote branches with `match(true)`
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
