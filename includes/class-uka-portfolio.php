<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Uka_Portfolio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Uka_Portfolio_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'UKA_PORTFOLIO_VERSION' ) ) {
			$this->version = UKA_PORTFOLIO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'uka-portfolio';

		$this->load_dependencies();
		$this->add_portfolio_post_type();
		$this->add_portfolio_metaboxes();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Uka_Portfolio_Post_Type. Adding "Portfolio" post type.
	 * - Uka_Portfolio_Metaboxes. Adding metaboxes.
	 * - Uka_Portfolio_Loader. Orchestrates the hooks of the plugin.
	 * - Uka_Portfolio_i18n. Defines internationalization functionality.
	 * - Uka_Portfolio_Admin. Defines all hooks for the admin area.
	 * - Uka_Portfolio_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for adding "Portfolio" post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uka-portfolio-post-type.php';

		/**
		 * The class responsible for adding metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uka-portfolio-metaboxes.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uka-portfolio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uka-portfolio-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uka-portfolio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uka-portfolio-public.php';

		$this->loader = new Uka_Portfolio_Loader();

	}

	/**
	 * Adds "Portfolio" post type.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_portfolio_post_type() {

		$plugin_post_type = new Uka_Portfolio_Post_Type();

		$this->loader->add_action( 'init', $plugin_post_type, 'register_portfolio_post_type' );
		$this->loader->add_filter( 'manage_edit-portfolio_columns', $plugin_post_type, 'add_thumbnail_column' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_post_type, 'display_thumbnail' );
		$this->loader->add_action( 'restrict_manage_posts', $plugin_post_type, 'add_taxonomy_filters' );
		$this->loader->add_filter( 'dashboard_glance_items', $plugin_post_type, 'add_portfolio_counts' );

	}

	/**
	 * Adds metaboxes.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_portfolio_metaboxes() {

		$prefix = '_uka_';
		$options = get_option( 'uka_portfolio_options' );

		$fields = array();

		if ( 'on' === $options[ 'portfolio_metaboxes_client' ] ) {
			$fields[] = array(
				'name' => esc_html__( 'Client:', 'uka-portfolio' ),
				'desc' => esc_html__( 'Display the client name.', 'uka-portfolio' ),
				'id'   => $prefix . 'portfolio_client',
				'type' => 'text',
				'std'  => '',
			);
		}

		if ( 'on' === $options[ 'portfolio_metaboxes_services' ] ) {
			$fields[] = array(
				'name' => esc_html__( 'Services:', 'uka-portfolio' ),
				'desc' => esc_html__( 'Display the services.', 'uka-portfolio' ),
				'id'   => $prefix . 'portfolio_services',
				'type' => 'text',
				'std'  => '',
			);
		}

		if ( 'on' === $options[ 'portfolio_metaboxes_external_url' ] ) {
			$fields[] = array(
				'name' => esc_html__( 'Website:', 'uka-portfolio' ),
				'desc' => esc_html__( 'Link this portfolio item to an external URL.', 'uka-portfolio' ),
				'id'   => $prefix . 'portfolio_external_url',
				'type' => 'text',
				'std'  => '',
			);
		}

		if ( 'on' === $options[ 'portfolio_metaboxes_add_to_showcase' ] ) {
			$fields[] = array(
				'name' => esc_html__( 'Add to the showcase:', 'uka-portfolio' ),
				'desc' => esc_html__( 'Add item to the showcase page.', 'uka-portfolio' ),
				'id'   => $prefix . 'add_to_showcase',
				'type' => 'checkbox',
				'std'  => '',
			);
		}

		if ( $fields ) {
			$portfolio_metaboxes = array(
				'id'          => 'portfolio-meta',
				'title'       => esc_html__( 'Portfolio Item Settings', 'uka-portfolio' ),
				'description' => esc_html__( '', 'uka-portfolio' ),
				'screen'      => array( 'portfolio' ),
				'context'     => 'normal',
				'priority'    => 'high',
				'fields'      => $fields,
			);

			$plugin_metaboxes = new Uka_Portfolio_Metaboxes( $portfolio_metaboxes );

			$this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'add_meta_boxes' );
			$this->loader->add_action( 'save_post', $plugin_metaboxes, 'save_meta_boxes', 10, 2 );
		}

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Uka_Portfolio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Uka_Portfolio_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Uka_Portfolio_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_settings_submenu' );
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'portfolio_items_per_page' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Uka_Portfolio_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'get_the_archive_title', $plugin_public, 'modify_portfolo_archive_titles' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Uka_Portfolio_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
