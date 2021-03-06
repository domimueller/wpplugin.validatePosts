<?php

/**
* Plugin Name: Post Validator
* Plugin URI: 
* Description: : Validierung von Inseraten mittels wp cron
* Version: 1.0
* Author: Dominique Müller
* Author URI: 
**/







$plugin_url = WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__));

/* include Scripts*/
function postValidator_customcss() {
    wp_enqueue_style( 'postValidator',  plugin_dir_url( __FILE__ ) . '/css/postValidator.css' );                      
}
add_action( 'wp_enqueue_scripts', 'postValidator_customcss');


/* INCLUDE FILES */
include $plugin_url . '/includes/cronjob/checkContigencyFunction.php';
include $plugin_url . '/includes/cronjob/checkDateFunction.php';
include $plugin_url . '/includes/cronjob/cronjob-checkDate.php';
include $plugin_url . '/includes/cronjob/cronjob-showAndSendContigencyExpiration.php';
include $plugin_url . '/includes/businessLogic.php';

?>