<?php
/**
 * The public-facing functionality of the plugin
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/public
 */

class Uka_Portfolio_Public {

	/**
	 * Modifies archive title.
	 *
	 * @since    1.0.0
	 */
	public function modify_portfolo_archive_titles( $title ) {

		if ( is_post_type_archive( 'portfolio' ) ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax( 'portfolio-category' ) ) {
			$title = single_term_title( '', false );
		} elseif ( is_tax( 'portfolio-tag' ) ) {
			$title = single_term_title( esc_html__( 'Tag: ', 'uka-portfolio' ), false );
		}
		return $title;

	}

}
