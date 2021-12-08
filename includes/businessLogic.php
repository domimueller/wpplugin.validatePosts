<?php


// function handle_custom_query_var( $query, $query_vars ) {
// 	if ( ! empty( $query_vars['productHasContingency'] ) ) {
// 		$query['meta_query'][] = array(
// 			'key' => 'productHasContingency',
// 			'value' => esc_attr( $query_vars['productHasContingency'] ),
// 		);
// 	}

// 	return $query;
// }
// add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2 );


add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {

        
		$hasContigency = get_field('hasContigency', 'user_' . get_current_user_id()); 
		$ContigencyNumber = get_field('ContigencyNumber', 'user_' . get_current_user_id()); 		
	  	// Get  products.
		
		if ($hasContigency == true){
			$args = array(

				'author' =>  get_current_user_id(),	
				'post_type'=> 'InseratPosttype',
				'post_status'=> 'publish',	
				'numberposts' => 11,
				
			    
			);
			$insertion_posts = get_posts( $args );	

			if ($ContigencyNumber > count($insertion_posts)){
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




