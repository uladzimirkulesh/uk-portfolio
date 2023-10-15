<?php
/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/includes
 */

class Uka_Portfolio_Activator {

	/**
	 * Compare WordPress version
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		global $wp_version;

		if ( version_compare( $wp_version, '4.7', '<' ) ) {
			wp_die( sprintf( esc_html__( 'This plugin requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'uka-portfolio' ), $wp_version ) );
		}

		// Set default plugin parameters
		$default_options = array(
			'portfolio_items_per_page' => 10,
			'showcase_items_per_page' => 10,
			'portfolio_comment_status' => 'off',
			'portfolio_metaboxes_client' => 'off',
			'portfolio_metaboxes_services' => 'off',
			'portfolio_metaboxes_external_url' => 'off',
			'portfolio_metaboxes_add_to_showcase' => 'on',
		);

		add_option( 'uka_portfolio_options', $default_options );

	}

}
