<?php
	function vernissageSendInsertionExpirationDates() {



		$args = array(
			'numberposts' => -1,
			'post_status'    => 'any',
		    'post_type'=> 'InseratPosttype',
		    'order'    => 'ASC', 
		        'meta_query' => array(

		        array(
		            'key' => 'insertion_duration_expiration_date',
		        )
		    ),
		    'orderby'   => 'meta_value_num'
		);  

		$insertion_posts_ALL=get_posts($args);

		/*comparison value*/
		$today = date("Ymd"); 

		/*display value*/
		$today_display = substr_replace(substr_replace($today, '-', 4, 0), '-', 7, 0);

		/*calculate value*/
		$todayCalculate = strtotime($today);
		$dateInOneWeekCalculate = strtotime("+7 day", $todayCalculate);

		/*back to comparison value*/
		$dateInOneWeek = date("Ymd", $dateInOneWeekCalculate); 


		$insertions_expired = array();
		$insertions_valid = array();
		$insertions_expiredNextWeek = array();


		foreach($insertion_posts_ALL as $insertion_post) {
			
			$post_title = $insertion_post->post_title;
			$expiry_date = get_post_meta($insertion_post->ID, 'insertion_duration_expiration_date')[0];


			if ($expiry_date < $today):
				$insertions_expired[] = $insertion_post;

			/*  THIS IS THE RELEVANT CHECK BUT STILL NEEDS THE UPPER CHECK SO THAT ALL OTHERS ARE NOT WITHIN THE 7 DAYS*/
			elseif ( $expiry_date < $dateInOneWeek):
				$insertions_expiredNextWeek[] = $insertion_post;
			else:
				$insertions_valid[] = $insertion_post;
			endif;	
			
		}		
			

			foreach ($insertions_expiredNextWeek as $expiredNextWeek){


				/*get post insead of id only*/
				$expiredNextWeek = get_post($expiredNextWeek);
				
				
				$userdata = um_fetch_user( $expiredNextWeek->post_author );
				$author_name = um_user('display_name');
				$author_mail = um_user('user_email');

				$insertionName = $expiredNextWeek->post_title;


				$msg = 'Hallo $author_name <br> Vielen Dank für dein Vertrauen in unseren Dienst. Du erhälst diese Nachricht, weil dein Inserat $insertionName in den nächsten 7 Tagen abläuft. Bitte besuche <a href=https://vernissage4u.com>vernissage4u </a> oder <a href=mailto:info@vernissage4u.com> kontaktiere uns </a> um das Inserat zu verlängern. Es werden diesbezüglich keine weiteren Erinnerung von vernissage4u.com verschickt. Das Inserat wird nach Ablauf automatisch deaktiviert. <br><br>  Beste Grüsse <br> Dein Team von vernissage4u';

				eval("\$msg = \"$msg\";");


				$receipients = array( $author_mail, 'dominique_mueller@gmx.ch', 'info@vernissage4u.com' );
		    	wp_mail( $receipients, 'Dein Inserat auf vernissage4u läuft aus', $msg );			

				
				$contigency_expiredNextWeek = 0;		
			}



	}

?>	