<?php
/*
 * Plugin Name: Zyscripts Enhancements
 * Plugin URI: http://zysys.org/wiki/Zyscript_Enhancements
 * Description: A series of site enhancements that optimize the site beyond caching
 * Version: 1.2
 * Author: Z. Bornheimer (Zysys)
 * Author URI: http://zysys.org
 * License: GPLv3
 * */

if (!function_exists('zyscripts_loadjs')):
function zyscripts_loadjs() {
    global $wp_scripts;
    if (is_admin()) {
        return;
    }
    $ignoreArray = array('jquery', 'jquery-core', 'jetpack', 'superfish', 'wpgroho', 'flexslider', 'flowplayer');
    foreach( $wp_scripts->queue as $handle ) {
        foreach ($wp_scripts->registered as $key => $value) {
            foreach ($ignoreArray as $ignore) {
                if ($key != $ignore && preg_match("/$ignore/i", $key)) {
                    array_push($ignoreArray, $key);
                }
            }
            $src = $wp_scripts->registered[$key]->src;
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
            if (substr($src, 0, 2) == '//') {
                $src = $protocol . $src;
            }
            if (substr($src, 0, 4) != 'http') {
                if (substr($src, 0, 1) != '/') {
                    $src = '/' . $src;
                }
                $src = get_site_url() . $src;
            }
            $handle = $wp_scripts->registered[$key]->handle;
            $deps = $wp_scripts->registered[$key]->deps;
            $ver = $wp_scripts->registered[$key]->ver;
            $args = $wp_scripts->registered[$key]->args;
            $in_footer = $wp_scripts->registered[$key]->in_footer;
            $reque = 0;
            if (!in_array($handle, $ignoreArray)) {
                if (in_array($handle, $wp_scripts->queue)) {
                    $reque = 1;
                    $src = str_replace('/http:\/\/zyscripts\.com\/loadjs.cgi\//', '', $src);
                    $src = 'http://zyscripts.com/loadjs.cgi/' . urlencode(urlencode(urlencode($src)));
                } else {
                #    $src = str_replace('/http:\/\/zyscripts\.com\/closure.cgi\//', '', $src);
                #    $src = 'http://zyscripts.com/closure.cgi/' . urlencode($src);
                }
                wp_deregister_script($handle);
                wp_register_script( $handle, $src, $deps, false, $in_footer );
                if ($reque) {
                    wp_enqueue_script( $handle );
                }
            }
        }
    }

}
add_action( 'wp_print_scripts', 'zyscripts_loadjs' );

function zyscripts_loadjs_rm_ver( $src, $handle ) {
    $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'script_loader_src', 'zyscripts_loadjs_rm_ver', 10, 2 );

endif;
if (!function_exists('zyscripts_loadcss')):
function zyscripts_loadcss() {
    global $wp_styles;
    if (is_admin()) {
        return;
    }
    $ignoreArray = array();
    foreach( $wp_styles->queue as $handle ) {
        foreach ($wp_styles->registered as $key => $value) {
            foreach ($ignoreArray as $ignore) {
                if ($key != $ignore && preg_match("/$ignore/i", $key)) {
                    array_push($ignoreArray, $key);
                }
            }
            $src = $wp_styles->registered[$key]->src;
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https:" : "http:";
            if (substr($src, 0, 2) == '//') {
                $src = $protocol . $src;
            }
            if (substr($src, 0, 4) != 'http') {
                if (substr($src, 0, 1) != '/') {
                    $src = '/' . $src;
                }
                $src = get_site_url() . $src;
            }
            $handle = $wp_styles->registered[$key]->handle;
            $deps = $wp_styles->registered[$key]->deps;
            $ver = $wp_styles->registered[$key]->ver;
            $args = $wp_styles->registered[$key]->args;
         #   if (!in_array($handle, $ignoreArray)) {
                $src = str_replace('/http:\/\/zyscripts\.com\/css.cgi\//', '', $src);
                $src = 'http://zyscripts.com/css.cgi/' . urlencode(urlencode(urlencode($src)));
                wp_deregister_style($handle);
                wp_register_style( $handle, $src, $deps, $ver );
          #  }
        }
    }
}
add_action( 'wp_print_styles', 'zyscripts_loadcss' );

function zyscripts_loadcss_rm_ver( $src, $handle ) {
    $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'zyscripts_loadcss_rm_ver', 10, 2 );


endif;
if (!function_exists('zyscripts_updater_init')):
/* hook updater to init */

/**
 * Load and Activate Plugin Updater Class.
 * @since 0.1.0
 */
function zyscripts_updater_init() {

    /* Load Plugin Updater */
    require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

    /* Updater Config */
    $config = array(
        'base'         => plugin_basename( __FILE__ ), //required
        'repo_uri'     => 'http://zysys.org/',
        'repo_slug'    => 'zyscripts',
    );

    /* Load Updater Class */
    new Plugin_Updater( $config );
}

add_action( 'init', 'zyscripts_updater_init' );
endif;
?>
