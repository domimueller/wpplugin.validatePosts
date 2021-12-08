<?php


add_filter( 'cron_schedules', 'vernissage_add_ContigencyInterval' );

function vernissage_add_ContigencyInterval( $schedules ) {
 $schedules['vernissageContigencyInterval'] = array(
 //'interval' => 86400,
 'interval' => 60,
 'display' => esc_html__( 'vernissageContigencyInterval' ),
 );

return $schedules;
 }



if ( !wp_next_scheduled( 'vernissageContingencyExpired' ) ) {

	wp_schedule_event( time(), 'vernissageContigencyInterval', 'vernissageContingencyExpired' );
}	


add_action( 'vernissageContingencyExpired', 'vernissageCheckContigency' );


	function vernissageCheckContigency() {

		$introduction = '<h2>Gültige vs. abgelaufene Kontingente von Usern (nach Datum, nicht "Kontingente-Zahl" = ausgeschöpft)</h2>';

		$today = date("Ymd"); 

		$contigency_expired = array();
		$contigency_valid = array();	
		
		$users = get_users();
		foreach ($users as $user){



			$contingency_expiration_date = get_user_meta($user->ID, 'contingency_expiration_date');	




			if ( isset($contingency_expiration_date[0]) and !empty($contingency_expiration_date[0])){
				$contingency_expiration_date = $contingency_expiration_date[0];
				if ($contingency_expiration_date < $today):
					$contigency_expired[] = $user;

				else:
					$contigency_valid[] = $user;
				endif;	

			}



		}



		
		$validString = '<h3>Folgende Kontingente sind noch gültig</h3>';
		$validString .= '<table>';
	  	$validString .= '<tr>';
	    $validString .= '<th>Autor</th>';
	    $validString .= '<th>E-Mail</th>';
	    $validString .= '<th>Ablaufdatum</th>';
		$validString .= '</tr>';

	
		foreach ($contigency_valid as $valids){



			$validString .= '<tr>';
			$validString .=	'<td>' . $valids->display_name;
			$validString .= '</td>';
			$validString .= '<td>' . $valids->user_email .'</td>';
			$validString .=	'<td>' . $valids->contingency_expiration_date . '</td>';
			$validString .= '</tr>'; 
		
		}


		$validString .= '</table>';
		
		$expiredString = '<h3>Folgende Kontingente sind abgelaufen</h3>';
		$expiredString .= '<table>';
	  	$expiredString .= '<tr>';
	    $expiredString .= '<th>Autor</th>';
	    $expiredString .= '<th>E-Mail</th>';
	    $expiredString .= '<th>Ablaufdatum</th>';
		$expiredString .= '</tr>';

	
		foreach ($contigency_expired as $expireds){
			$expiredString .= '<tr>';
			$expiredString .=	'<td>'  . $expireds->display_name . '</a>';
			$expiredString .= '</td>';
			$expiredString .= '<td>' . $expireds->user_email .'</td>';
			$expiredString .=	'<td>' . $expireds->contingency_expiration_date . '</td>';
			$expiredString .= '</tr>'; 
		
		}
		$expiredString .= '</table>';
		

		$message =  $introduction . $expiredString . $validString;	

	    wp_mail( 'dominique_mueller@gmx.ch', 'Kontigente', $message );
	    return $message;

	}

?>
