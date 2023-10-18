<?php
/**
 * @link              https://uladzimirkulesh.com/
 * @since             1.0.0
 * @package           Uk_Portfolio
 *
 * @wordpress-plugin
 * Plugin Name:       UK Portfolio
 * Plugin URI:        https://uladzimirkulesh.com/portfolio/uk-portfolio
 * Description:       Adds Project Post Type to your site.
 * Version:           1.0.0
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
define( 'UK_PORTFOLIO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-uk-portfolio-activator.php
 */
function activate_uk_portfolio() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-uk-portfolio-activator.php';
	Uk_Portfolio_Activator::activate();
}
register_activation_hook( __FILE__, 'activate_uk_portfolio' );

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
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'uk_portfolio_settings_link' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_uk_portfolio() {

	$plugin = new Uk_Portfolio();
	$plugin->run();

}
run_uk_portfolio();
