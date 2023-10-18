<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://uladzimirkulesh.com/
 * @since      1.0.0
 *
 * @package    Uk_Portfolio
 * @subpackage Uk_Portfolio/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Uk_Portfolio
 * @subpackage Uk_Portfolio/includes
 * @author     Uladzimir Kulesh <hello@uladzimirkulesh.com>
 */
class Uk_Portfolio_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'uk-portfolio',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
