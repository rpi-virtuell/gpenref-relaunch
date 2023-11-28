<?php

class Gpen_Setup {

	function __construct() {
		add_action( 'wp_enqueue_scripts', function() {
			if ( is_page_template( 'page-list.php' ) ) {
				wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.css', [], '1.5.1' );
				wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.js', [], '1.5.1', true );

				wp_enqueue_script( 'gpen-map', plugin_dir_url(__FILE__) , ['jquery', 'leaflet'], '1.0', true );

				$locations = [];
				$query = new WP_Query( [
					'post_type' => 'restaurant',
				] );
				foreach ( $query->posts as $post ) {
					$location            = rwmb_get_value( 'location', '', $post->ID );
					$location['title']   = $post->post_title;
					$location['address'] = rwmb_get_value( 'address', '', $post->ID );
					$location['icon']    = rwmb_get_value( 'icon', '', $post->ID );
					$locations[]         = $location;
				}
				wp_localize_script( 'gpen-map', 'Locations', $locations );
			}
		} );
	}



}