<?php
/**
 * Plugin Name:      gpenref-relaunch
 * Plugin URI:       https://github.com/rpi-virtuell/gpenref-relaunch
 * Description:      Plugin that grants features to gpenref website
 * Author:           Daniel Reintanz
 * Version:          1.3.7
 * Domain Path:     /languages
 * Text Domain:      gpenref-relaunch
 * Licence:          GPLv3
 * GitHub Plugin URI: https://github.com/rpi-virtuell/gpenref-relaunch
 * GitHub Branch:     master
 */

require_once( "gpen-setup.php" );


class Gpenref_Relauch {


	function __construct() {
		add_action( 'init', array( $this, 'add_plugin_pll_strings' ) );
		add_shortcode( 'gpen_frontpage_map', array( $this, 'display_frontpage_map' ) );

	}

	function add_plugin_pll_strings() {
		if ( function_exists( 'pll_register_string' ) ) {
			pll_register_string( 'gpen_participants', 'Participants Worldwide' );
		}

	}

	function display_frontpage_map() {
		$places            = get_posts( array( 'posttype' => 'places', 'numberposts' => - 1 ) );
		$number_places     = count( $places );
		$places_string_pll = 'Participants Worldwide';
		if ( function_exists( 'pll__' ) ) {
			$places_string_pll = ppl__( 'gpen_participants' );
		}
		ob_start();

		?>

        <div class="gpen-frontpage-map">
            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/gpen_illustration_startseite_2.png' ?>">
            <div class="gpen-banner-places">
                <div><?php echo $number_places ?></div>
                <div><?php echo $places_string_pll ?></div>
            </div>
        </div>
		<?php

		return ob_get_clean();

	}

}

new Gpenref_Relauch();
new Gpen_Setup();