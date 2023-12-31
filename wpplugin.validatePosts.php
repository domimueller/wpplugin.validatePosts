<?php

/**
* Plugin Name: Post Validator
* Plugin URI: 
* Description: Validierung von Inseraten mittels wp cron
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

include $plugin_url . '/includes/cronjob/GenerateInsertionUpdatedMail/cronjob-checkInsertionDate.php';
include $plugin_url . '/includes/cronjob/GenerateReminderMails/cronjob-SendContigencyExpirationReminder.php';
include $plugin_url . '/includes/cronjob/GenerateInsertionUpdatedMail/checkInsertionDateFunction.php';
include $plugin_url . '/includes/cronjob/GenerateReminderMails/SendContigencyExpirationReminder.php';
include $plugin_url . '/includes/cronjob/GenerateReminderMails/SendInsertionExpirationReminder.php';
include $plugin_url . '/includes/cronjob/GenerateReminderMails/cronjob-SendInsertionExpirationReminder.php';
include $plugin_url . '/includes/businessLogicForwarding.php';

?>