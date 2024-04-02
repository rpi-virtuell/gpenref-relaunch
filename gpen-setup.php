<?php

class Gpen_Setup {

	function __construct() {
		add_action( 'wp_enqueue_scripts', function () {
			if ( is_page_template( 'page-list.php' ) ) {
				wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.css', [], '1.5.1' );
				wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.js', [], '1.5.1', true );

				wp_enqueue_script( 'gpen-map', plugin_dir_url( __FILE__ ), [ 'jquery', 'leaflet' ], '1.0', true );

				$locations = [];
				$query     = new WP_Query( [
					'post_type' => 'location',
				] );
				foreach ( $query->posts as $post ) {
					$location            = get_post_meta( $post->ID,'osm_location',true );
					$location['title']   = $post->post_title;
					$location['address'] = rwmb_get_value( 'address', '', $post->ID );
					$location['icon']    = rwmb_get_value( 'icon', '', $post->ID );
					$locations[]         = $location;
				}
				wp_localize_script( 'gpen-map', 'Locations', $locations );
			}
		} );
		add_shortcode( 'display_gpen_map', array( $this, 'display_gpen_map' ) );
	}


	function display_gpen_map() {
		ob_start();
		?>
        <div id="map" style="width: 100%; height: 600px"></div>
		<?php
		return ob_get_clean();
	}


}