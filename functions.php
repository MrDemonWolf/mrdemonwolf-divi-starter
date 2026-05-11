<?php
/**
 * Divi Child Theme
 * Functions.php
 *
 * Supports Divi 4 and Divi 5.
 *
 * ===== NOTES ==================================================================
 *
 * Unlike style.css, the functions.php of a child theme does not override its
 * counterpart from the parent. Instead, it is loaded in addition to the parent's
 * functions.php. (Specifically, it is loaded right before the parent's file.)
 *
 * In that way, the functions.php of a child theme provides a smart, trouble-free
 * method of modifying the functionality of a parent theme.
 *
 * =============================================================================== */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load child theme text domain for future translatable strings.
 */
function mrdemonwolf_setup()
{
    load_child_theme_textdomain( 'mrdemonwolf-divi-starter', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mrdemonwolf_setup' );

/**
 * Enqueue parent + child styles and the child theme script.
 */
function mrdemonwolf_enqueue_scripts()
{
    // Parent stylesheet, versioned against the parent theme's own Version header.
    $parent_version = wp_get_theme( get_template() )->get( 'Version' );
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        $parent_version ?: false
    );

    // Child stylesheet with mtime cache-busting.
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [ 'parent-style' ],
        filemtime( get_stylesheet_directory() . '/style.css' )
    );

    // Child theme script.
    $script_path = get_stylesheet_directory() . '/script.js';
    $script_uri  = get_stylesheet_directory_uri() . '/script.js';
    $version     = file_exists( $script_path ) ? filemtime( $script_path ) : false;

    wp_enqueue_script( 'mrdemonwolf-script', $script_uri, [], $version, true );
}
add_action( 'wp_enqueue_scripts', 'mrdemonwolf_enqueue_scripts' );

/**
 * Replace the Howdy greeting with a time-of-day greeting.
 */
function mrdemonwolf_replace_howdy( $wp_admin_bar )
{
    $hour = (int) wp_date( 'G' );
    $msg  = match ( true ) {
        $hour >= 5 && $hour <= 11  => 'Good morning,',
        $hour >= 12 && $hour <= 18 => 'Good afternoon,',
        default                    => 'Good evening,', // 19-23 and 0-4
    };

    $my_account = $wp_admin_bar->get_node( 'my-account' );

    if ( $my_account && isset( $my_account->title ) ) {
        $newtitle = str_replace( 'Howdy,', $msg, $my_account->title );
        $wp_admin_bar->add_node( [
            'id'    => 'my-account',
            'title' => $newtitle,
        ] );
    }
}
// Priority 100: late enough to run after the default my-account node is built (default priority 7).
add_action( 'admin_bar_menu', 'mrdemonwolf_replace_howdy', 100 );

/**
 * Disable author info from oEmbed response data.
 */
function mrdemonwolf_disable_embed_author( $data )
{
    unset( $data['author_url'] );
    unset( $data['author_name'] );
    return $data;
}
add_filter( 'oembed_response_data', 'mrdemonwolf_disable_embed_author' );

/**
 * RankMath + Divi 5 content-analysis fix.
 *
 * Divi 5 stores layouts as blocks. RankMath's researcher sees raw block markup
 * and reports 0 words. Pipe content through `the_content` so blocks render
 * before RankMath analyzes. Only registered when RankMath is active.
 *
 * Harmless on Divi 4 (the_content is a no-op for Divi 4 shortcode-rendered
 * content in this context), so we register unconditionally when RankMath loads.
 */
function mrdemonwolf_register_rank_math_divi5_fix()
{
    if ( ! defined( 'RANK_MATH_VERSION' ) ) {
        return;
    }

    add_filter( 'rank_math/researcher/post_content', function ( $content, $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post ) {
            return $content;
        }
        $rendered = apply_filters( 'the_content', $post->post_content );
        return $rendered ? $rendered : $content;
    }, 10, 2 );
}
add_action( 'init', 'mrdemonwolf_register_rank_math_divi5_fix' );
