<?php
/**
 * Divi Child Theme
 * Functions.php
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

/**
 * Enqueue parent theme styles
 */
function divichild_enqueue_scripts()
{
    // Enqueue parent theme stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Enqueue child theme stylesheet with cache-busting
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['parent-style'],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Enqueue child theme script (script.js)
    $script_path = get_stylesheet_directory() . '/script.js';
    $script_uri  = get_stylesheet_directory_uri() . '/script.js';
    $version     = file_exists($script_path) ? filemtime($script_path) : false;

    wp_enqueue_script('grittolead-script', $script_uri, [], $version, true);
}
add_action('wp_enqueue_scripts', 'divichild_enqueue_scripts');

/**
 * Replace the howdy greeting with a custom greeting based on time of day
 */
function fancy_replace_howdy($wp_admin_bar)
{
    $Hour = date('G');
    $msg  = '';
    if ($Hour >= 5 && $Hour <= 11) {
        $msg = 'Good morning,';
    } elseif ($Hour >= 12 && $Hour <= 18) {
        $msg = 'Good afternoon,';
    } elseif ($Hour >= 19 || $Hour <= 4) {
        $msg = 'Good evening,';
    }
    $my_account = $wp_admin_bar->get_node('my-account');

    // Only proceed if the node exists and has a title property
    if ($my_account && isset($my_account->title)) {
        $newtitle = str_replace('Howdy,', $msg, $my_account->title);
        $wp_admin_bar->add_node([
            'id'    => 'my-account',
            'title' => $newtitle,
        ]);
    }
}

add_filter('admin_bar_menu', 'fancy_replace_howdy', 9992);

/**
 * Disable author from embeds response data.
 */
add_filter('oembed_response_data', 'disable_embeds_filter_oembed_response_data_');
function disable_embeds_filter_oembed_response_data_($data, $url, $args)
{
    unset($data['author_url']);
    unset($data['author_name']);
    return $data;
}
