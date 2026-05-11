<?php
/**
 * Bootstrap file for PHPStan static analysis.
 *
 * Defines constants and stubs that would normally come from external sources
 * (Divi parent theme, RankMath plugin) so PHPStan can analyze functions.php
 * without those dependencies installed.
 */

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

if ( ! defined( 'RANK_MATH_VERSION' ) ) {
    define( 'RANK_MATH_VERSION', '1.0.0' );
}
