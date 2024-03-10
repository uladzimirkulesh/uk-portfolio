<?php
/**
 * The admin-specific functionality of the plugin.
 */

class UK_Portfolio_Admin {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/uk-portfolio-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Create settings page submenu.
	 *
	 * @since    1.0.0
	 */
	public function create_settings_submenu() {

		add_options_page(
			esc_html__( 'Portfolio Settings', 'uk-portfolio' ),
			esc_html__( 'Portfolio', 'uk-portfolio' ),
			'manage_options',
			'uk-portfolio',
			array( $this, 'settings_page' )
		);

		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register settings for settings page.
	 *
	 * @since    1.1.2
	 */
	public function register_settings() {

		register_setting( 'uk_portfolio_settings_group', 'uk_portfolio_options', 'sanitize_options' );

		// Add reading settings section
		add_settings_section(
			'uk_portfolio_reading_settings',
			esc_html__( 'Reading Settings', 'uk-portfolio' ),
			array( $this, 'reading_settings_section'),
			'uk-portfolio'
		);

		add_settings_field(
			'uk_portfolio_projects_per_page',
			esc_html__( 'Portfolio pages show at most', 'uk-portfolio' ),
			array( $this, 'projects_per_page_field'),
			'uk-portfolio',
			'uk_portfolio_reading_settings',
			array(
				'label_for' => 'projects_per_page',
			)
		);

		// Add discussion settings section
		add_settings_section(
			'uk_portfolio_discussion_settings',
			esc_html__( 'Discussion Settings', 'uk-portfolio' ),
			null,
			'uk-portfolio'
		);

		add_settings_field(
			'uk_portfolio_project_comments',
			esc_html__( 'Allow comments', 'uk-portfolio' ),
			array( $this, 'project_comments_field'),
			'uk-portfolio',
			'uk_portfolio_discussion_settings',
			array(
				'label_for' => 'project_comments',
			)
		);

	}

	/**
	 * Sanitize_options for settings page.
	 *
	 * @since    1.1.0
	 */
	public function sanitize_options( $input ) {

		$input[ 'projects_per_page' ] = absint( $input[ 'projects_per_page' ] );
		$input[ 'project_comments' ] = sanitize_text_field( $input[ 'project_comments' ] );

		return $input;

	}

	/**
	 * Adds some text to reading settings section.
	 *
	 * @since    1.0.0
	 */
	public function reading_settings_section() {
		echo '<p>' . esc_html__( 'Specify the number of projects that you would like to see on the portfolio archive pages.', 'uk-portfolio' ) . '</p>';
	}

	/**
	 * Output the projects per page settings field.
	 *
	 * @since    1.1.3
	 */
	public function projects_per_page_field() {

		$options = get_option( 'uk_portfolio_options' );

		if ( empty( $options[ 'projects_per_page' ] ) ) {
			$options[ 'projects_per_page' ] = 10;
		}

		$html = sprintf(
			'<input name="uk_portfolio_options[projects_per_page]" type="number" step="1" min="1" id="projects_per_page" value="%1$s" class="small-text"> %2$s',
			esc_attr( $options[ 'projects_per_page' ] ),
			esc_html__( 'projects', 'uk-portfolio' )
		);

		echo wp_kses(
			$html,
			array(
				'input' => array(
					'name' => array(),
					'type' => array(),
					'step' => array(),
					'min' => array(),
					'id' => array(),
					'value' => array(),
					'class' => array()
				)
			)
		);

	}

	/**
	 * Output the comment status settings field.
	 *
	 * @since    1.1.3
	 */
	public function project_comments_field() {

		$options = get_option( 'uk_portfolio_options' );
		$value = $options[ 'project_comments' ];

		$html = '<fieldset>';
		$html .= '<label for="project_comments">';
		$html .= '<input type="hidden" name="uk_portfolio_options[project_comments]" value="off" />';
		$html .= sprintf( '<input type="checkbox" class="checkbox" id="project_comments" name="uk_portfolio_options[project_comments]" value="on" %1$s />', checked( $value, 'on', false ) );
		$html .= sprintf( '%1$s</label>', esc_html__( 'Allow people to submit comments on projects', 'uk-portfolio' ) );
		$html .= '</fieldset>';

		echo wp_kses(
			$html,
			array(
				'fieldset',
				'label' => array(
					'for' => array()
				),
				'input' => array(
					'type' => array(),
					'name' => array(),
					'value' => array(),
					'class' => array(),
					'id' => array(),
					'checked' => array()
				)
			)
		);

	}

	/**
	 * Create settings page.
	 *
	 * @since    1.0.0
	 */
	public function settings_page() {

		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Portfolio Settings', 'uk-portfolio' ); ?></h1>

			<form method="post" action="options.php">
				<?php
				settings_fields( 'uk_portfolio_settings_group' );
				do_settings_sections( 'uk-portfolio' );
				submit_button();
				?>
			</form>
		</div>
		<?php

	}

}
