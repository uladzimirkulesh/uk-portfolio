<?php
/**
 * Plugin Name:       UK Portfolio
 * Plugin URI:        https://uladzimirkulesh.com/portfolio/uk-portfolio
 * Description:       Adds Project Post Type to your site.
 * Version:           1.1.5
 * Author:            Uladzimir Kulesh
 * Author URI:        https://uladzimirkulesh.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       uk-portfolio
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'UK_PORTFOLIO_VERSION', '1.1.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-uk-portfolio-activator.php
 *
 * @since    1.1.2
 */
function uk_portfolio_activate() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uk-portfolio-activator.php';
	UK_Portfolio_Activator::activate();

}
register_activation_hook( __FILE__, 'uk_portfolio_activate' );

/**
 * The code that runs after WordPress has finished loading
 * but before any headers are sent (here we clear the permalink cache).
 *
 * @since    1.1.5
 */
function uk_portfolio_flush_rewrite() {

	if ( ! get_option( 'uk_portfolio_options' ) ) {
		flush_rewrite_rules( false );
	}

}
add_action( 'init', 'uk_portfolio_flush_rewrite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-uk-portfolio.php';

/**
 * Create link for settings page.
 *
 * @since    1.0.0
 */
function uk_portfolio_settings_link( $settings ) {

	$settings[] = '<a href="'. get_admin_url( null, 'options-general.php?page=uk-portfolio' ) .'">' . esc_html__( 'Settings', 'uk-portfolio' ) . '</a>';
	return $settings;

}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'uk_portfolio_settings_link' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.1.2
 */
function uk_portfolio_run() {

	$plugin = new UK_Portfolio();
	$plugin->run();

}
uk_portfolio_run();
