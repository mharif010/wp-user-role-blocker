<?php
/*
 * Plugin Name:       User Rule Blocker
 * Plugin URI:        
 * Description:       User rule block the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            mh Arif
 * Author URI:        https://mharif.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       urblocked
 * Domain Path:       /languages
 */

add_action('init', function () {
    add_role('urb_user_blocked', __('Blocked', 'urblocked'), array('blocked' => true));
    add_rewrite_rule('blocked/?$', 'index.php?blocked=1', 'top');
});

add_action('init', function () {
    if (is_admin() && current_user_can('blocked')) {
        wp_redirect(get_home_url() . '/blocked');
        die();
    }
});

add_filter('query_vars', function ($query_vars) {
    $query_vars[] = 'blocked';
    return $query_vars;
});

add_action('template_redirect', function () {
    $is_blocked = intval(get_query_var('blocked'));
    if ($is_blocked) { ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Blocked title</title>
        </head>

        <body>
            <h2><?php _e('You are blocked', 'urblocked'); ?></h2>
        </body>

        </html>
<?php
        die();
    }
});
