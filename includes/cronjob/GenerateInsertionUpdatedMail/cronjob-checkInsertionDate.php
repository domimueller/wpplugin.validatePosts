<?php

/* Cronjob Intervals */




add_filter( 'cron_schedules', 'vernissage_add_cron_interval' );

function vernissage_add_cron_interval( $schedules ) {
 $schedules['vernissageCheckInsertionInterval'] = array(
 'interval' => 86400, // daily
 'display' => esc_html__( 'vernissage Interval' ),
 );

return $schedules;
 }





if ( !wp_next_scheduled( 'vernissageCheckInsertionExpired' ) ) {

	wp_schedule_event( time(), 'vernissageCheckInsertionInterval', 'vernissageCheckInsertionExpired' );
}	


// execute function in checkDateFunction.php File

do_action('vernissageCheckInsertionExpired');
add_action( 'vernissageCheckInsertionExpired', 'vernissageCheckInsertionExpirationDates' );



?>  