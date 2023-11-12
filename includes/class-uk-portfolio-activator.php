<?php
/**
 * Fired during plugin activation
 *
 * This class defines all code necessary to run during the plugin's activation.
 */

class UK_Portfolio_Activator {

	/**
	 * Compare WordPress version and set parameters.
	 *
	 * @since    1.1.0
	 */
	public static function activate() {

		global $wp_version;

		if ( version_compare( $wp_version, '6.2', '<' ) ) {
			wp_die( sprintf( esc_html__( 'This plugin requires at least WordPress version 6.2. You are running version %s. Please upgrade and try again.', 'uk-portfolio' ), $wp_version ) );
		}

		// Set default plugin parameters
		$default_options = array(
			'projects_per_page' => 10,
			'project_comments' => 'off'
		);
		add_option( 'uk_portfolio_options', $default_options );

	}

}
