<?php


add_filter( 'cron_schedules', 'vernissageInsertionSendInterval' );

function vernissageInsertionSendInterval( $schedules ) {
 $schedules['vernissageInsertionSendInterval'] = array(
'interval' => 604800, //weekly
 'display' => esc_html__( 'vernissageInsertionSendInterval' ),
 );

return $schedules;
 }



if ( !wp_next_scheduled( 'vernissageInsertionExpired' ) ) {

	wp_schedule_event( time(), 'vernissageInsertionSendInterval', 'vernissageInsertionExpired' );
}	


do_action('vernissageInsertionExpired');
add_action( 'vernissageInsertionExpired', 'vernissageSendInsertionExpirationDates' );




?>
