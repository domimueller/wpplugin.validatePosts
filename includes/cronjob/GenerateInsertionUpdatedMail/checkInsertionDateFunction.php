<?php

	function vernissageCheckInsertionExpirationDates() {

	    $args = array(
			'numberposts' => -1,
	    	'post_type'=> 'InseratPosttype',
		);  

		$insertion_posts_ALL=get_posts($args);

		$today = date("Ymd"); 
		$today_display = substr_replace(substr_replace($today, '-', 4, 0), '-', 7, 0);

		$insertions_expired = array();
		$insertions_valid = array();

		foreach($insertion_posts_ALL as $insertion_post) {
			
			$post_title = $insertion_post->post_title;
			$expiry_date = get_post_meta($insertion_post->ID, 'insertion_duration_expiration_date')[0];
			

			if ($expiry_date < $today):
				$insertions_expired[] = $insertion_post;

			else:
				$insertions_valid[] = $insertion_post;
			endif;	
			
		}

		
	 
		$post_status_new = 'pending';
		$post_title_addon = 'ABGELAUFEN UND VERARBEITET - '; 	
		foreach ($insertions_expired as $insertion_expired){
			
			
			$post_title_new = $post_title_addon . $insertion_expired->post_title;
			
			// if post title is already updated, do not update it again!
			if (substr($insertion_expired->post_title, 0, strlen($post_title_addon)) == $post_title_addon ){
			wp_update_post(
	  			  array (
	        			'ID'         => $insertion_expired->ID,
	        			'post_status'=> $post_status_new,
	    			)
			);
			}
			else{
			wp_update_post(
	  			  array (
	        			'ID'         => $insertion_expired->ID,
	        			'post_status'=> $post_status_new,
	        			'post_title' => $post_title_new,
	    			)
			);

			}
		}	


		

		// get mail content
		
		$checkAblaufdatumPage = get_pages(array(
		    'meta_key' => '_wp_page_template',
		    'meta_value' => 'template-checkAblaufdatum.php'
		));

		$urlVar = $checkAblaufdatumPage[0]->guid;

		$msg = 'Die Inserate wurden durch die Website automatisch geprüft und aktualisiert. Bitte prüfe den aktuellen Stand auf <a href=$urlVar> Vernissage4u</a>! Melde dich auf vernissage4u an, bevor du den Link öffnest.';

		eval("\$msg = \"$msg\";");

		$receipients = array('info@vernissage4u.com', 'dominique_mueller@gmx.ch');
	    
	    wp_mail( $receipients, 'Inserate überprüft', $msg );

	}

?>