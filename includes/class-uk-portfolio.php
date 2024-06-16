<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */

class UK_Portfolio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      UK_Portfolio_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * @since    1.1.2
	 */
	public function __construct() {

		if ( defined( 'UK_PORTFOLIO_VERSION' ) ) {
			$this->version = UK_PORTFOLIO_VERSION;
		} else {
			$this->version = '1.1.5';
		}
		$this->plugin_name = 'uk-portfolio';

		$this->load_dependencies();
		$this->set_locale();
		$this->add_project_post_type();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - UK_Portfolio_Loader. Orchestrates the hooks of the plugin.
	 * - UK_Portfolio_i18n. Defines internationalization functionality.
	 * - UK_Portfolio_Post_Type. Adding "Project" post type.
	 * - UK_Portfolio_Metaboxes. Adding metaboxes.
	 * - UK_Portfolio_Admin. Defines all hooks for the admin area.
	 * - UK_Portfolio_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uk-portfolio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uk-portfolio-i18n.php';

		/**
		 * The class responsible for adding "Project" post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-uk-portfolio-post-type.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-uk-portfolio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-uk-portfolio-public.php';

		$this->loader = new UK_Portfolio_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the UK_Portfolio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new UK_Portfolio_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Adds "Project" post type.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_project_post_type() {

		$plugin_post_type = new UK_Portfolio_Post_Type();

		$this->loader->add_action( 'init', $plugin_post_type, 'register_project_post_type' );
		$this->loader->add_filter( 'manage_edit-uk-project_columns', $plugin_post_type, 'add_thumbnail_column' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_post_type, 'display_thumbnail' );
		$this->loader->add_action( 'restrict_manage_posts', $plugin_post_type, 'add_taxonomy_filters' );
		$this->loader->add_filter( 'dashboard_glance_items', $plugin_post_type, 'add_projects_count' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new UK_Portfolio_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_settings_submenu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new UK_Portfolio_Public();

		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'projects_per_page' );

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
	 * @return    UK_Portfolio_Loader    Orchestrates the hooks of the plugin.
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
