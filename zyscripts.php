<?php
/*
 * Plugin Name: Zyscripts Enhancements
 * Plugin URI: http://zysys.org/wiki/Zyscript_Enhancements
 * Description: A series of site enhancements that optimize the site beyond caching
 * Version: 0.5
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
        $ignoreArray = explode(' ', 'jquery flexslider');
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
                if (substr($src , -3) == '.js') {
                    $handle = $wp_scripts->registered[$key]->handle;
                    $deps = $wp_scripts->registered[$key]->deps;
                    $ver = $wp_scripts->registered[$key]->ver;
                    $args = $wp_scripts->registered[$key]->args;
                    $reque = 0;
                    if (!in_array($handle, $ignoreArray)) {
                        if (in_array($handle, $wp_scripts->queue)) {
                            $reque = 1;
                            $src = preg_replace('/http:\/\/zyscripts\.com\/loadjs.cgi\//', '', $src);
                            $src = 'http://zyscripts.com/loadjs.cgi/' . urlencode($src);
                        } else {
                            $src = preg_replace('/http:\/\/zyscripts\.com\/closure.cgi\//', '', $src);
                            $src = 'http://zyscripts.com/closure.cgi/' . urlencode($src);
                        }
                        wp_deregister_script($handle);
                        wp_register_script( $handle, $src, $deps, $ver );
                        if ($reque) {
                            wp_enqueue_script( $handle, $src, $deps, $ver );
                        }
                    }
                }
            }
        }
    }
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

add_action( 'wp_print_scripts', 'zyscripts_loadjs' );
add_action( 'init', 'zyscripts_updater_init' );
endif;

?>
