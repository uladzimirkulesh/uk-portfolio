<?php
/**
 * The public-facing functionality of the plugin.
 */

class UK_Portfolio_Public {

	/**
	 * Changes the number of projects on archive pages.
	 *
	 * @since    1.0.0
	 */
	public function projects_per_page( $query ) {

		$options = get_option( 'uk_portfolio_options' );
		$portfolio_items_per_page = $options[ 'projects_per_page' ];

		if ( ! is_admin() && $query->is_main_query() && $query->is_archive ) {
			if ( $query->is_post_type_archive( 'uk-project' ) || $query->is_tax( 'uk-project_category' ) || $query->is_tax( 'uk-project_tag' ) ) {
				$query->set( 'posts_per_page', $portfolio_items_per_page );
			}
		}

	}

}
