<?php
/**
 * The admin-specific functionality of the plugin
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/admin
 */

class Uka_Portfolio_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uka-portfolio-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Create settings page submenu.
	 *
	 * @since    1.0.0
	 */
	public function create_settings_submenu() {

		add_options_page(
			esc_html__( 'Portfolio Settings', 'uka-portfolio' ),
			esc_html__( 'Portfolio', 'uka-portfolio' ),
			'manage_options',
			'portfolio',
			array( $this, 'settings_page' )
		);

		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register settings for settings page.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {

		register_setting( 'uka_portfolio_settings_group', 'uka_portfolio_options', 'sanitize_options' );

		// Add reading settings section
		add_settings_section(
			'reading_settings',
			esc_html__( 'Reading Settings', 'uka-portfolio' ),
			array( $this, 'reading_settings_section'),
			'portfolio'
		);

		add_settings_field(
			'portfolio_items_per_page',
			esc_html__( 'Portfolio pages show at most', 'uka-portfolio' ),
			array( $this, 'portfolio_items_per_page_field'),
			'portfolio',
			'reading_settings',
			array(
				'label_for' => 'portfolio_items_per_page',
			)
		);

		add_settings_field(
			'showcase_items_per_page',
			esc_html__( 'The showcase page shows at most', 'uka-portfolio' ),
			array( $this, 'showcase_items_per_page_field'),
			'portfolio',
			'reading_settings',
			array(
				'label_for' => 'showcase_items_per_page',
			)
		);

		// Add discussion settings section
		add_settings_section(
			'discussion_settings',
			esc_html__( 'Discussion Settings', 'uka-portfolio' ),
			null,
			'portfolio'
		);

		add_settings_field(
			'portfolio_comment_status',
			esc_html__( 'Allow comments', 'uka-portfolio' ),
			array( $this, 'portfolio_comment_status_field'),
			'portfolio',
			'discussion_settings',
			array(
				'label_for' => 'portfolio_comment_status',
			)
		);

		// Add metaboxes settings section
		add_settings_section(
			'metaboxes_settings',
			esc_html__( 'Custom Meta Boxes Settings', 'uka-portfolio' ),
			array( $this, 'metaboxes_settings_section'),
			'portfolio'
		);

		add_settings_field(
			'portfolio_metaboxes',
			esc_html__( 'Display Meta Boxes', 'uka-portfolio' ),
			array( $this, 'metaboxes_field'),
			'portfolio',
			'metaboxes_settings',
			array(
				'label_for' => 'portfolio_metaboxes',
			)
		);

	}

	/**
	 * Sanitize_options for settings page.
	 *
	 * @since    1.0.0
	 */
	public function sanitize_options( $input ) {

		$input[ 'portfolio_items_per_page' ] = absint( $input[ 'portfolio_items_per_page' ] );
		$input[ 'showcase_items_per_page' ] = absint( $input[ 'showcase_items_per_page' ] );
		$input[ 'portfolio_comment_status' ] = sanitize_text_field( $input[ 'portfolio_comment_status' ] );
		$input[ 'portfolio_metaboxes_client' ] = sanitize_text_field( $input[ 'portfolio_metaboxes_client' ] );
		$input[ 'portfolio_metaboxes_services' ] = sanitize_text_field( $input[ 'portfolio_metaboxes_services' ] );
		$input[ 'portfolio_metaboxes_external_url' ] = sanitize_text_field( $input[ 'portfolio_metaboxes_external_url' ] );
		$input[ 'portfolio_metaboxes_add_to_showcase' ] = sanitize_text_field( $input[ 'portfolio_metaboxes_add_to_showcase' ] );

		return $input;

	}

	/**
	 * Adds some text to reading settings section.
	 *
	 * @since    1.0.0
	 */
	public function reading_settings_section() {
		echo '<p>' . esc_html__( 'Specify the number of portfolio items that you would like to see on the portfolio archive pages and on the portfolio showcase page.', 'uka-portfolio' ) . '</p>';
	}

	/**
	 * Output the portfolio items per page settings field.
	 *
	 * @since    1.0.0
	 */
	public function portfolio_items_per_page_field() {

		$options = get_option( 'uka_portfolio_options' );

		if ( empty( $options[ 'portfolio_items_per_page' ] ) ) {
			$options[ 'portfolio_items_per_page' ] = 10;
		}

		?>
		<input name="uka_portfolio_options[portfolio_items_per_page]" type="number" step="1" min="1" id="portfolio_items_per_page" value="<?php echo esc_attr( $options[ 'portfolio_items_per_page' ] ) ?>" class="small-text">
		<?php
		esc_html_e( ' items', 'uka-portfolio' );

	}

	/**
	 * Output the showcase items per page settings field.
	 *
	 * @since    1.0.0
	 */
	public function showcase_items_per_page_field() {

		$options = get_option( 'uka_portfolio_options' );

		if ( empty( $options[ 'showcase_items_per_page' ] ) ) {
			$options[ 'showcase_items_per_page' ] = 10;
		}

		?>
		<input name="uka_portfolio_options[showcase_items_per_page]" type="number" step="1" min="1" id="showcase_items_per_page" value="<?php echo esc_attr( $options[ 'showcase_items_per_page' ] ) ?>" class="small-text">
		<?php
		esc_html_e( ' items', 'uka-portfolio' );

	}

	/**
	 * Output the comment status settings field.
	 *
	 * @since    1.0.0
	 */
	public function portfolio_comment_status_field() {

		$options = get_option( 'uka_portfolio_options' );
		$value = $options[ 'portfolio_comment_status' ];

		$html  = '<fieldset>';
		$html  .= '<label for="portfolio_comment_status">';
		$html  .= '<input type="hidden" name="uka_portfolio_options[portfolio_comment_status]" value="off" />';
		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="portfolio_comment_status" name="uka_portfolio_options[portfolio_comment_status]" value="on" %1$s />', checked( $value, 'on', false ) );
		$html  .= sprintf( '%1$s</label>', esc_html__( 'Allow people to submit comments on portfolio items', 'uka-portfolio' ) );
		$html  .= '</fieldset>';

		echo $html;

	}

	/**
	 * Adds some text to metaboxes settings section.
	 *
	 * @since    1.0.0
	 */
	public function metaboxes_settings_section() {
		echo '<p>' . esc_html__( 'Select the meta boxes that will be displayed on the portfolio item page.', 'uka-portfolio' ) . '</p>';
	}

	/**
	 * Output the metaboxes settings field.
	 *
	 * @since    1.0.0
	 */
	public function metaboxes_field() {

		$options = get_option( 'uka_portfolio_options' );
		$client = $options[ 'portfolio_metaboxes_client' ];
		$services = $options[ 'portfolio_metaboxes_services' ];
		$external_url = $options[ 'portfolio_metaboxes_external_url' ];
		$add_to_showcase = $options[ 'portfolio_metaboxes_add_to_showcase' ];

		$html  = '<fieldset>';
		$html  .= sprintf( '<legend class="screen-reader-text"><span>%1$s</span></legend>', esc_html__( 'Custom Meta Boxes Settings', 'uka-portfolio' ) );

		$html  .= '<label for="portfolio_metaboxes_client">';
		$html  .= '<input type="hidden" name="uka_portfolio_options[portfolio_metaboxes_client]" value="off" />';
		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="portfolio_metaboxes_client" name="uka_portfolio_options[portfolio_metaboxes_client]" value="on" %1$s />', checked( $client, 'on', false ) );
		$html  .= sprintf( '%1$s</label>', esc_html__( 'Client', 'uka-portfolio' ) );
		$html  .= '<br />';

		$html  .= '<label for="portfolio_metaboxes_services">';
		$html  .= '<input type="hidden" name="uka_portfolio_options[portfolio_metaboxes_services]" value="off" />';
		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="portfolio_metaboxes_services" name="uka_portfolio_options[portfolio_metaboxes_services]" value="on" %1$s />', checked( $services, 'on', false ) );
		$html  .= sprintf( '%1$s</label>', esc_html__( 'Services', 'uka-portfolio' ) );
		$html  .= '<br />';

		$html  .= '<label for="portfolio_metaboxes_external_url">';
		$html  .= '<input type="hidden" name="uka_portfolio_options[portfolio_metaboxes_external_url]" value="off" />';
		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="portfolio_metaboxes_external_url" name="uka_portfolio_options[portfolio_metaboxes_external_url]" value="on" %1$s />', checked( $external_url, 'on', false ) );
		$html  .= sprintf( '%1$s</label>', esc_html__( 'Website', 'uka-portfolio' ) );
		$html  .= '<br />';

		$html  .= '<label for="portfolio_metaboxes_add_to_showcase">';
		$html  .= '<input type="hidden" name="uka_portfolio_options[portfolio_metaboxes_add_to_showcase]" value="off" />';
		$html  .= sprintf( '<input type="checkbox" class="checkbox" id="portfolio_metaboxes_add_to_showcase" name="uka_portfolio_options[portfolio_metaboxes_add_to_showcase]" value="on" %1$s />', checked( $add_to_showcase, 'on', false ) );
		$html  .= sprintf( '%1$s</label>', esc_html__( 'Add to the showcase', 'uka-portfolio' ) );
		$html  .= '<br />';

		$html  .= '</fieldset>';

		echo $html;

	}

	/**
	 * Create settings page.
	 *
	 * @since    1.0.0
	 */
	public function settings_page() {

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Portfolio Settings', 'uka-portfolio' ); ?></h1>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'uka_portfolio_settings_group' );
				do_settings_sections( 'portfolio' );
				submit_button();
				?>
			</form>
		</div>
		<?php

	}

	/**
	 * Changes the number of portfolio items on archive pages.
	 *
	 * @since    1.0.4
	 */
	public function portfolio_items_per_page( $query ) {

		$options = get_option( 'uka_portfolio_options' );
		$portfolio_items_per_page = $options[ 'portfolio_items_per_page' ];

		if ( ! is_admin() && $query->is_main_query() && $query->is_archive ) {
			if ( $query->is_post_type_archive( 'portfolio' ) || $query->is_tax( 'portfolio-category' ) || $query->is_tax( 'portfolio-tag' ) ) {
				$query->set( 'posts_per_page', $portfolio_items_per_page );
			}
		}

	}

}
