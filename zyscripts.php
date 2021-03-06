<?php
/*
 * Plugin Name: Zyscripts Enhancements
 * Plugin URI: http://zysys.org/wiki/Zyscript_Enhancements
 * Description: A series of site enhancements that optimize the site beyond caching
 * Version: 1.5
 * Author: Z. Bornheimer (Zysys)
 * Author URI: http://zysys.org
 * License: GPLv3
 * */

if (!function_exists('zyscripts_loadjs')):
function zyscripts_loadjs($url) {
    if ( is_admin() ) return $url;
    $ignoreArray = array('jquery', 'jetpack', 'superfish', 'wpgroho', 'flexslider', 'flowplayer');
    foreach ($ignoreArray as $ignore) { 
        if (strpos($url, $ignore) !== false) {
            return str_replace($url, '//zyscripts.com/closure.cgi/'.urlencode(urlencode(urlencode($url))), $url);
        }
    }
    return str_replace($url, '//zyscripts.com/loadjs.cgi/'.urlencode(urlencode(urlencode($url))), $url);
}
add_filter( 'script_loader_src', 'zyscripts_loadjs' );

endif;

if (!function_exists('zyscripts_loadcss')):
function zyscripts_loadcss($url) {
    if ( is_admin() ) return $url;
    return str_replace($url, '//zyscripts.com/css.cgi/'.urlencode(urlencode(urlencode($url))), $url);
}
add_filter( 'style_loader_src', 'zyscripts_loadcss' );
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
