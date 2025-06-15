<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

define('DIST_DEF', 'dist');

define('DIST_URI', get_template_directory_uri() . '/' . DIST_DEF);
define('DIST_PATH', get_template_directory() . '/' . DIST_DEF);

define('JS_DEPENDENCY', array());
define('JS_LOAD_IN_FOOTER', true);

define('VITE_SERVER', 'http://localhost:3000');
define('VITE_ENTRY_POINT', '/main.js');

add_action('wp_enqueue_scripts', function() {
    if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true) {
        // insert hmr into head for live reload
        function vite_head_module_hook() {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . VITE_ENTRY_POINT . '"></script>';
        }
        add_action('wp_footer', 'vite_head_module_hook');  
    } else {
        $manifest = json_decode(
            file_get_contents( DIST_PATH . '/.vite/manifest.json' ),
            true
        );

        if (is_array($manifest)) {
            $css_file = $manifest['main.js']['css'][0];
            wp_enqueue_style('main', DIST_URI . '/' . $css_file);

            $js_file = $manifest['main.js']['file'];
            wp_enqueue_script(
                'main',
                DIST_URI . '/' . $js_file,
                JS_DEPENDENCY,
                '1.0.0',
                array(
                    'in_footer' => JS_LOAD_IN_FOOTER
                )
            );
        }
    }
});
