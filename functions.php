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
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'divichild_enqueue_scripts');

/**
 * Replace the howdy greeting with a custom greeting based on time of day
 */
function fancy_replace_howdy($wp_admin_bar)
{
    $Hour = date('G');
    $msg = "";
    if ($Hour >= 5 && $Hour <= 11) {
        $msg = "Good morning,";
    } else if ($Hour >= 12 && $Hour <= 18) {
        $msg = "Good afternoon,";
    } else if ($Hour >= 19 || $Hour <= 4) {
        $msg = "Good evening,";
    }
    $my_account = $wp_admin_bar->get_node('my-account');
    $newtitle = str_replace('Howdy,', $msg, $my_account->title);
    $wp_admin_bar->add_node(array(
        'id' => 'my-account',
        'title' => $newtitle,
    )
    );
}

add_filter('admin_bar_menu', 'fancy_replace_howdy', 20);

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