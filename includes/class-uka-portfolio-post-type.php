<?php
/**
 * The class responsible for adding "Portfolio" post type
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/includes
 */

class Uka_Portfolio_Post_Type {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_theme_support( 'post-thumbnails', array( 'portfolio' ) );
	}

	/**
	 * Register portfolio post type.
	 *
	 * @since    1.0.0
	 */
	public function register_portfolio_post_type() {

		// Register the post type
		$labels = array(
			'name'                     => esc_html__( 'Portfolio', 'uka-portfolio' ),
			'singular_name'            => esc_html__( 'Portfolio Item', 'uka-portfolio' ),
			'all_items'                => esc_html__( 'All Portfolio Items', 'uka-portfolio' ),
			'add_new'                  => esc_html__( 'Add New', 'uka-portfolio' ),
			'add_new_item'             => esc_html__( 'Add New Portfolio Item', 'uka-portfolio' ),
			'edit_item'                => esc_html__( 'Edit Portfolio Item', 'uka-portfolio' ),
			'new_item'                 => esc_html__( 'Add New', 'uka-portfolio' ),
			'view_item'                => esc_html__( 'View Portfolio Item', 'uka-portfolio' ),
			'search_items'             => esc_html__( 'Search Portfolio Items', 'uka-portfolio' ),
			'not_found'                => esc_html__( 'No portfolio items found', 'uka-portfolio' ),
			'not_found_in_trash'       => esc_html__( 'No portfolio items found in trash', 'uka-portfolio' ),
			'item_updated'             => esc_html__( 'Portfolio item updated.', 'uka-portfolio' ),
			'item_published'           => esc_html__( 'Portfolio item published.', 'uka-portfolio' ),
			'item_published_privately' => esc_html__( 'Portfolio item published privately.', 'uka-portfolio' ),
			'item_reverted_to_draft'   => esc_html__( 'Portfolio item reverted to draft.', 'uka-portfolio' ),
			'item_scheduled'           => esc_html__( 'Portfolio item scheduled.', 'uka-portfolio' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'capability_type' => 'post',
			'rewrite'         => array( "slug" => "portfolio" ),
			'has_archive'     => true,
			'menu_position'   => 20,
			'menu_icon'       => 'dashicons-portfolio',
			'show_in_rest'    => true,
		);

		$options = get_option( 'uka_portfolio_options' );

		if ( 'on' === $options[ 'portfolio_comment_status' ] ) {
			$args['supports'] = array_merge(
				$args['supports'],
				array( 'comments' )
			);
		}

		$args = apply_filters( 'uka_portfolio_args', $args );

		register_post_type( 'portfolio', $args );

		// Register categories
		$taxonomy_portfolio_category_labels = array(
			'name'                       => esc_html__( 'Portfolio Categories', 'uka-portfolio' ),
			'singular_name'              => esc_html__( 'Portfolio Category', 'uka-portfolio' ),
			'search_items'               => esc_html__( 'Search Portfolio Categories', 'uka-portfolio' ),
			'popular_items'              => esc_html__( 'Popular Portfolio Categories', 'uka-portfolio' ),
			'all_items'                  => esc_html__( 'All Portfolio Categories', 'uka-portfolio' ),
			'parent_item'                => esc_html__( 'Parent Portfolio Category', 'uka-portfolio' ),
			'parent_item_colon'          => esc_html__( 'Parent Portfolio Category:', 'uka-portfolio' ),
			'edit_item'                  => esc_html__( 'Edit Portfolio Category', 'uka-portfolio' ),
			'update_item'                => esc_html__( 'Update Portfolio Category', 'uka-portfolio' ),
			'add_new_item'               => esc_html__( 'Add New Portfolio Category', 'uka-portfolio' ),
			'new_item_name'              => esc_html__( 'New Portfolio Category Name', 'uka-portfolio' ),
			'separate_items_with_commas' => esc_html__( 'Separate portfolio categories with commas', 'uka-portfolio' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove portfolio categories', 'uka-portfolio' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used portfolio categories', 'uka-portfolio' ),
			'menu_name'                  => esc_html__( 'Categories', 'uka-portfolio' ),
		);

		$taxonomy_portfolio_category_args = array(
			'labels'            => $taxonomy_portfolio_category_labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_tagcloud'     => false,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'portfolio-category' ),
			'query_var'         => true,
			'show_in_rest'      => true,
		);

		register_taxonomy( 'portfolio-category', array( 'portfolio' ), $taxonomy_portfolio_category_args );

		// Register tags
		$taxonomy_portfolio_tag_labels = array(
			'name'                       => esc_html__( 'Portfolio Tags', 'uka-portfolio' ),
			'singular_name'              => esc_html__( 'Portfolio Tag', 'uka-portfolio' ),
			'search_items'               => esc_html__( 'Search Portfolio Tags', 'uka-portfolio' ),
			'popular_items'              => esc_html__( 'Popular Portfolio Tags', 'uka-portfolio' ),
			'all_items'                  => esc_html__( 'All Portfolio Tags', 'uka-portfolio' ),
			'parent_item'                => esc_html__( 'Parent Portfolio Tag', 'uka-portfolio' ),
			'parent_item_colon'          => esc_html__( 'Parent Portfolio Tag:', 'uka-portfolio' ),
			'edit_item'                  => esc_html__( 'Edit Portfolio Tag', 'uka-portfolio' ),
			'update_item'                => esc_html__( 'Update Portfolio Tag', 'uka-portfolio' ),
			'add_new_item'               => esc_html__( 'Add New Portfolio Tag', 'uka-portfolio' ),
			'new_item_name'              => esc_html__( 'New Portfolio Tag Name', 'uka-portfolio' ),
			'separate_items_with_commas' => esc_html__( 'Separate portfolio tags with commas', 'uka-portfolio' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove portfolio tags', 'uka-portfolio' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used portfolio tags', 'uka-portfolio' ),
			'menu_name'                  => esc_html__( 'Tags', 'uka-portfolion' ),
		);

		$taxonomy_portfolio_tag_args = array(
			'labels'            => $taxonomy_portfolio_tag_labels,
			'public'            => true,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_tagcloud'     => false,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'portfolio-tag' ),
			'query_var'         => true,
			'show_in_rest'      => true,
		);

		register_taxonomy( 'portfolio-tag', array( 'portfolio' ), $taxonomy_portfolio_tag_args );
	}

	/**
	 * Add thumbnail column.
	 *
	 * @since    1.0.0
	 */
	public function add_thumbnail_column( $columns ) {

		$column_thumb = array( 'portfolio-thumbnail' => esc_html__('Thumbnail', 'uka-portfolio' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );

		return $columns;

	}

	/**
	 * Display thumbnail.
	 *
	 * @since    1.0.0
	 */
	public function display_thumbnail( $column ) {

		global $post;

		switch ( $column ) {
			case 'portfolio-thumbnail':
				echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
				break;
		}

	}

	/**
	 * Add taxonomy filters to the admin page.
	 *
	 * @since    1.0.0
	 */
	public function add_taxonomy_filters() {

		global $typenow;

		// Use taxonomy name or slug
		$taxonomies = array( 'portfolio-category', 'portfolio-tag' );

		// Post type for the filter
		if ( $typenow == 'portfolio' ) {
			foreach ( $taxonomies as $tax_slug ) {
				$current_tax_slug = isset( $_GET[ $tax_slug ] ) ? $_GET[ $tax_slug ] : false;
				$tax_obj = get_taxonomy( $tax_slug );
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms( $tax_slug );

				if ( count( $terms ) > 0) {
					echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
					echo "<option value=''>$tax_name</option>";
					foreach ( $terms as $term ) {
						echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
					}
					echo "</select>";
				}
			}
		}

	}

	/**
	 * Add count to "RIGHT NOW" dashboard widget.
	 *
	 * @since    1.0.0
	 */
	public function add_portfolio_counts() {

		if ( ! post_type_exists( 'portfolio' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'portfolio' );

		if ( $num_posts && $num_posts->publish ) {
			$text = esc_html( _nx( '%s Portfolio Item', '%s Portfolio Items', $num_posts->publish, 'Number of portfolio items', 'uka-portfolio' ) );

			$text             = sprintf( $text, number_format_i18n( $num_posts->publish ) );
			$post_type_object = get_post_type_object( 'portfolio' );

			if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
				printf( '<li class="portfolio-count"><a href="edit.php?post_type=portfolio">%s</a></li>', $text );
			} else {
				printf( '<li class="portfolio-count"><span>%s</span></li>', $text );
			}
		}

		if ( $num_posts && $num_posts->pending > 0 ) {
			$text = esc_html( _nx( '%s Portfolio Item Pending', '%s Portfolio Items Pending', $num_posts->pending, 'Number of pending portfolio items', 'uka-portfolio' ) );

			$text             = sprintf( $text, number_format_i18n( $num_posts->pending ) );
			$post_type_object = get_post_type_object( 'portfolio' );

			if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
				printf( '<li class="portfolio-pending-count"><a href="edit.php?post_status=pending&post_type=portfolio">%s</a></li>', $text );
			}
		}

	}

}
