<?php
/**
 * PHPUnit bootstrap — loads Composer autoloader and Brain Monkey.
 *
 * functions.php is intentionally NOT loaded here; individual test files require
 * it via WP_Mock/Brain Monkey setUp() so each test starts with a clean state.
 */

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __DIR__ ) . '/' );
}

\WP_Mock::bootstrap();
