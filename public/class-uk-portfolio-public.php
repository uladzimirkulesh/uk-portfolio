<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://uladzimirkulesh.com/
 * @since      1.0.0
 *
 * @package    Uk_Portfolio
 * @subpackage Uk_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Uk_Portfolio
 * @subpackage Uk_Portfolio/public
 * @author     Uladzimir Kulesh <hello@uladzimirkulesh.com>
 */
class Uk_Portfolio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uk-portfolio-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/uk-portfolio-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Changes the number of projects on archive pages.
	 *
	 * @since    1.0.0
	 */
	public function projects_per_page( $query ) {

		$options = get_option( 'uk_portfolio_options' );
		$portfolio_items_per_page = $options[ 'projects_per_page' ];

		if ( ! is_admin() && $query->is_main_query() && $query->is_archive ) {
			if ( $query->is_post_type_archive( 'uk-project' ) || $query->is_tax( 'uk-project-category' ) || $query->is_tax( 'uk-project-tag' ) ) {
				$query->set( 'posts_per_page', $portfolio_items_per_page );
			}
		}

	}

}
