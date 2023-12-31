<?php


add_filter( 'cron_schedules', 'vernissage_add_ContigencyInterval' );

function vernissage_add_ContigencyInterval( $schedules ) {
 $schedules['vernissageContigencyInterval'] = array(
 'interval' => 604800, //weekly
 'display' => esc_html__( 'vernissageContigencyInterval' ),
 );

return $schedules;
 }



if ( !wp_next_scheduled( 'vernissageContingencyExpired' ) ) {

	wp_schedule_event( time(), 'vernissageContigencyInterval', 'vernissageContingencyExpired' );
}	


do_action('vernissageContingencyExpired');
add_action( 'vernissageContingencyExpired', 'vernissageCheckContigencyExpirationDates' );




?>
