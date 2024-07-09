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
		wp_enqueue_style( 'gpen_style', plugin_dir_url( __FILE__ ) . 'assets/css/gpen_styles.css' );
		wp_enqueue_style( 'blog-script-regular', plugin_dir_url( __FILE__ ) . 'assets/blog-script-regular.woff' );
		add_shortcode( 'gpen_frontpage_map', array( $this, 'display_frontpage_map' ) );
		add_action( 'save_post', array( $this, 'add_lang_tag' ), 10, 3 );


	}

    function add_lang_tag( $post_id, $post, $update )  {
	    if (pll_is_translated_post_type(get_post_type($post_id)))
	    {
		    $lang = pll_get_post_language( $post_id );
            wp_set_post_terms($post_id, array($lang), "post_tag");
        }
    }

	function add_plugin_pll_strings() {
		if ( function_exists( 'pll_register_string' ) ) {
			pll_register_string( 'gpen_participants', 'Participants Worldwide' );

			pll_register_string( 'gpen_readmore', 'Read more' );
		}

	}

	function display_frontpage_map() {

		$places        = get_posts( array( 'post_type' => 'places', 'numberposts' => - 1 ) );
		$number_places = 0;
		if ( ! empty( $places ) ) {
			$number_places = count( $places );
		}
		$places_string_pll = 'Participants Worldwide';
		if ( function_exists( 'pll__' ) ) {
			$places_string_pll = pll__( 'Participants Worldwide' );
		}
		ob_start();

		?>

        <div class="gpen-frontpage-map">
            <img class="gpen-banner-image"
                 src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/gpen_illustration_startseite_2.png' ?>" alt="">
            <div class="gpen-banner-places">

                                <img class="gpen-banner-logo"
                                     src="
				<?php echo plugin_dir_url( __FILE__ ) . 'assets/GPEN_Logo_inverted.png' ?>" alt="">
            </div>

        </div>
		<?php

		return ob_get_clean();
	}


}

new Gpenref_Relauch();
new Gpen_Setup();