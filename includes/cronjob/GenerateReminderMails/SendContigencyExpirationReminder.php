<?php
	function vernissageCheckContigencyExpirationDates() {



		/*comparison value*/
		$today = date("Ymd"); 

		/*display value*/
		$today_display = substr_replace(substr_replace($today, '-', 4, 0), '-', 7, 0);

		/*calculate value*/
		$todayCalculate = strtotime($today);
		$dateInOneWeekCalculate = strtotime("+7 day", $todayCalculate);

		/*back to comparison value*/
		$dateInOneWeek = date("Ymd", $dateInOneWeekCalculate); 



		$contigency_expired = array();
		$contigency_valid = array();
		$contigency_expiredNextWeek = array();
		
		$users = get_users();
		foreach ($users as $user){



			$contingency_expiration_date = get_user_meta($user->ID, 'contingency_expiration_date');	


			if ( isset($contingency_expiration_date[0]) and !empty($contingency_expiration_date[0])){
				$contingency_expiration_date = $contingency_expiration_date[0];
				
				if ($contingency_expiration_date < $today):
					$contigency_expired[] = $user->ID;

				/*  THIS IS THE RELEVANT CHECK BUT STILL NEEDS THE UPPER CHECK SO THAT ALL OTHERS ARE NOT WITHIN THE 7 DAYS*/
				elseif ( $contingency_expiration_date < $dateInOneWeek):
	
					$contigency_expiredNextWeek[] = $user->ID;
				else:
					$contigency_valid[] = $user->ID;
				endif;	

			}



		}



			foreach ($contigency_expiredNextWeek as $expiredNextWeek){

				$userdata = um_fetch_user( $expiredNextWeek );
				$name = um_user('display_name');
				$mail = um_user('user_email');

				$msg = 'Hallo $name <br> Vielen Dank für dein Vertrauen in unseren Dienst. Du erhälst diese Nachricht, weil dein Paket in den nächsten 7 Tagen abläuft. Bitte besuche <a href=https://vernissage4u.com>vernissage4u </a> oder <a href=mailto:info@vernissage4u.com> kontaktiere uns </a> für ein weiteres Paket. Es werden keine weiteren Erinnerung von vernissage4u.com verschickt. <br><br>  Beste Grüsse <br> Dein Team von vernissage4u';

				eval("\$msg = \"$msg\";");

				$receipients = array($mail, 'info@vernissage4u.com', 'dominique_mueller@gmx.ch');
		    	wp_mail( $receipients, 'Dein Paket auf vernissage4u läuft aus', $msg );			
	
			}



	}

?>	