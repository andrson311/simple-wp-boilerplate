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
    }
});
