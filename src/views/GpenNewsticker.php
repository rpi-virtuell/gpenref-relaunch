<?php

namespace GPEN\views;

class GpenNewsticker {
	function __construct() {
		add_shortcode( 'newsticker', [ $this, 'newsticker_shortcode' ] );

	}

	function newsticker_shortcode() {
		$news = get_posts( array(
			'post_type'     => 'news',
			'numberposts'  => '5',
			'orderby'      => 'date',
			'order'        => 'DESC',
		) );
		if ( is_array( $news ) ) {
			ob_start();
			?>
            <div class="newsticker">
                <div class="newsticker-inner">
					<?php
					foreach ( $news as $news_item ) {
						if ( is_a( $news_item, 'WP_Post' ) ) {
							echo '<div class="newsticker-item"><a href="' . get_permalink( $news_item->ID ) . '">' . $news_item->post_title . '</a></div>';
						} else {
							echo '<div class="newsticker-item">' . $news_item . '</div>';
						}
					}
					?>

                </div>
            </div>
			<?php
			return ob_get_clean();

		}


	}
}