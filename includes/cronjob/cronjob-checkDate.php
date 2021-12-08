<?php

/* Cronjob Intervals */




add_filter( 'cron_schedules', 'vernissage_add_cron_interval' );

function vernissage_add_cron_interval( $schedules ) {
 $schedules['vernissageInterval'] = array(
 //'interval' => 86400,
 'interval' => 3600,
 'display' => esc_html__( 'vernissage Interval' ),
 );

return $schedules;
 }





if ( !wp_next_scheduled( 'vernissageCronHook' ) ) {

	wp_schedule_event( time(), 'vernissageInterval', 'vernissageCronHook' );
}	


// execute function in checkDateFunction.php File

do_action('vernissageCronHook');
add_action( 'vernissageCronHook', 'vernissageCheckExpiryDates' );



?>  