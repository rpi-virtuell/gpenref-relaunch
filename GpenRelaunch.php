<?php
/**
 * Plugin Name:      GpenRelaunch
 * Plugin URI:       https://github.com/rpi-virtuell/gpenref-relaunch
 * Description:      Plugin that grants features to gpenref website
 * Author:           Daniel Reintanz
 * Version:          1.3.8
 * Domain Path:     /languages
 * Text Domain:      GpenRelaunch
 * Licence:          GPLv3
 * GitHub Plugin URI: https://github.com/rpi-virtuell/gpenref-relaunch
 * GitHub Branch:     master
 */

require_once __DIR__ . '/vendor/autoload.php';

use GPEN\GpenSetup;
use GPEN\views\GpenNewsticker;


class GpenRelaunch {

	private string $version = '1.3.8';


	function __construct() {
		add_action( 'admin_notices', [ $this, 'check_composer_install_status' ] );

		new GpenSetup();

		new GpenNewsticker();


		add_action( 'init', array( $this, 'add_plugin_pll_strings' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_shortcode( 'gpen_frontpage_map', array( $this, 'display_frontpage_map' ) );
		add_action( 'save_post', array( $this, 'add_lang_tag' ), 10, 3 );


	}

	public function enqueue_scripts(): void {
		wp_enqueue_style( 'gpen_style', plugin_dir_url( __FILE__ ) . 'src/assets/css/gpen_styles.css', [], $this->version );
		wp_enqueue_style( 'blog-script-regular', plugin_dir_url( __FILE__ ) . 'src/assets/blog-script-regular.woff', [], $this->version );

	}

	function check_composer_install_status() {
		// Adjust this to point to the correct path if needed
		$autoload_path = plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

		if ( ! file_exists( $autoload_path ) ) {
			echo '<div class="notice notice-error"><p>';
			echo '⚠️ <strong>Composer dependencies not installed.</strong> Please run <code>composer install</code> in the plugin directory.';
			echo '</p></div>';
		}
	}

	function add_lang_tag( $post_id, $post, $update ) {
		if ( pll_is_translated_post_type( get_post_type( $post_id ) ) ) {
			$lang = pll_get_post_language( $post_id );
			wp_set_post_terms( $post_id, array( $lang ), "post_tag" );
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
            <div class="gpen-banner-image"
                 style="background-image: url(<?php echo plugin_dir_url( __FILE__ ) . 'assets/gpen_illustration_startseite_with_text.png' ?>)">
            </div>

        </div>
		<?php

		return ob_get_clean();
	}


}

new GpenRelaunch();
