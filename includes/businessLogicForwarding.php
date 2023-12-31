<?php


$configuration_data = custom_set_gform_Configuration();

add_filter( 'gform_confirmation_' . $configuration_data['INSERATE_ERFASSEN_FORM_ID'], 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {

        
		$hasContigency = get_field('hasContigency', 'user_' . get_current_user_id()); 
		$ContigencyNumber = get_field('ContigencyNumber', 'user_' . get_current_user_id()); 		
	  	// Get  products.
		
		if ($hasContigency == true){
			$args = array(

				'author' =>  get_current_user_id(),	
				'post_type'=> 'InseratPosttype',
				'post_status'=> 'publish',	
				'numberposts' => -1,
				
			    
			);
			$insertion_posts = get_posts( $args );	
			
			$today = date("Ymd");

			
			if ($ContigencyNumber > count($insertion_posts) && $today < $ContigencyExpirationDate){
			    // get redirect page by template name
			    $pages = get_pages(array(
			        'meta_key' => '_wp_page_template',
			        'meta_value' => 'template-Contigency.php'
			    ));

		        if(isset($pages[0])) {
					$url = get_page_link($pages[0]->ID);
				}

				$confirmation = array( 'redirect' => $url );
			   	
			}else{
				
				// get redirect page by template name

				$urlContigencyEmpty =get_post_type_archive_link('product');


				$confirmation = array( 'redirect' => $urlContigencyEmpty );
			   
			}
		}

		
	return $confirmation;
}

?>




