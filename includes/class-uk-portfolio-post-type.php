<?php
/**
 * The class responsible for adding "Project" post type
 */

class UK_Portfolio_Post_Type {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		add_theme_support( 'post-thumbnails', array( 'uk-portfolio' ) );

	}

	/**
	 * Register project post type.
	 *
	 * @since    1.0.0
	 */
	public function register_project_post_type() {

		// Register the post type
		$labels = array(
			'name'                     => esc_html__( 'Projects', 'uk-portfolio' ),
			'singular_name'            => esc_html__( 'Project', 'uk-portfolio' ),
			'all_items'                => esc_html__( 'All Projects', 'uk-portfolio' ),
			'add_new'                  => esc_html__( 'Add New', 'uk-portfolio' ),
			'add_new_item'             => esc_html__( 'Add New Project', 'uk-portfolio' ),
			'edit_item'                => esc_html__( 'Edit Project', 'uk-portfolio' ),
			'new_item'                 => esc_html__( 'Add New', 'uk-portfolio' ),
			'view_item'                => esc_html__( 'View Project', 'uk-portfolio' ),
			'search_items'             => esc_html__( 'Search Projects', 'uk-portfolio' ),
			'not_found'                => esc_html__( 'No projects found', 'uk-portfolio' ),
			'not_found_in_trash'       => esc_html__( 'No projects found in trash', 'uk-portfolio' ),
			'item_updated'             => esc_html__( 'Project updated.', 'uk-portfolio' ),
			'item_published'           => esc_html__( 'Project published.', 'uk-portfolio' ),
			'item_published_privately' => esc_html__( 'Project published privately.', 'uk-portfolio' ),
			'item_reverted_to_draft'   => esc_html__( 'Project reverted to draft.', 'uk-portfolio' ),
			'item_scheduled'           => esc_html__( 'Project scheduled.', 'uk-portfolio' ),
		);

		$args = array(
			'labels'          => $labels,
			'public'          => true,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ),
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'portfolio' ),
			'has_archive'     => true,
			'menu_position'   => 20,
			'menu_icon'       => 'dashicons-portfolio',
			'show_in_rest'    => true,
		);

		$options = get_option( 'uk_portfolio_options' );

		if ( 'on' === $options[ 'project_comments' ] ) {
			$args['supports'] = array_merge(
				$args['supports'],
				array( 'comments' )
			);
		}

		$args = apply_filters( 'uk-project_args', $args );

		register_post_type( 'uk-project', $args );

		// Register categories
		$taxonomy_project_category_labels = array(
			'name'                       => esc_html__( 'Categories', 'uk-portfolio' ),
			'singular_name'              => esc_html__( 'Category', 'uk-portfolio' ),
			'search_items'               => esc_html__( 'Search Categories', 'uk-portfolio' ),
			'popular_items'              => esc_html__( 'Popular Categories', 'uk-portfolio' ),
			'all_items'                  => esc_html__( 'All Categories', 'uk-portfolio' ),
			'parent_item'                => esc_html__( 'Parent Category', 'uk-portfolio' ),
			'parent_item_colon'          => esc_html__( 'Parent Category:', 'uk-portfolio' ),
			'edit_item'                  => esc_html__( 'Edit Category', 'uk-portfolio' ),
			'update_item'                => esc_html__( 'Update Category', 'uk-portfolio' ),
			'add_new_item'               => esc_html__( 'Add New Category', 'uk-portfolio' ),
			'new_item_name'              => esc_html__( 'New Category Name', 'uk-portfolio' ),
			'separate_items_with_commas' => esc_html__( 'Separate categories with commas', 'uk-portfolio' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove categories', 'uk-portfolio' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'uk-portfolio' ),
			'menu_name'                  => esc_html__( 'Categories', 'uk-portfolio' ),
		);

		$taxonomy_project_category_args = array(
			'labels'            => $taxonomy_project_category_labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_tagcloud'     => false,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'project-category' ),
			'query_var'         => true,
			'show_in_rest'      => true,
		);

		register_taxonomy( 'uk-project_category', array( 'uk-project' ), $taxonomy_project_category_args );

		// Register tags
		$taxonomy_project_tag_labels = array(
			'name'                       => esc_html__( 'Tags', 'uk-portfolio' ),
			'singular_name'              => esc_html__( 'Tag', 'uk-portfolio' ),
			'search_items'               => esc_html__( 'Search Tags', 'uk-portfolio' ),
			'popular_items'              => esc_html__( 'Popular Tags', 'uk-portfolio' ),
			'all_items'                  => esc_html__( 'All Tags', 'uk-portfolio' ),
			'parent_item'                => esc_html__( 'Parent Tag', 'uk-portfolio' ),
			'parent_item_colon'          => esc_html__( 'Parent Tag:', 'uk-portfolio' ),
			'edit_item'                  => esc_html__( 'Edit Tag', 'uk-portfolio' ),
			'update_item'                => esc_html__( 'Update Tag', 'uk-portfolio' ),
			'add_new_item'               => esc_html__( 'Add New Tag', 'uk-portfolio' ),
			'new_item_name'              => esc_html__( 'New Tag Name', 'uk-portfolio' ),
			'separate_items_with_commas' => esc_html__( 'Separate tags with commas', 'uk-portfolio' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove tags', 'uk-portfolio' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used tags', 'uk-portfolio' ),
			'menu_name'                  => esc_html__( 'Tags', 'uk-portfolion' ),
		);

		$taxonomy_project_tag_args = array(
			'labels'            => $taxonomy_project_tag_labels,
			'public'            => true,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_tagcloud'     => false,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'project-tag' ),
			'query_var'         => true,
			'show_in_rest'      => true,
		);

		register_taxonomy( 'uk-project_tag', array( 'uk-project' ), $taxonomy_project_tag_args );
	}

	/**
	 * Add thumbnail column.
	 *
	 * @since    1.0.0
	 */
	public function add_thumbnail_column( $columns ) {

		$column_thumb = array( 'uk-project_thumbnail' => esc_html__('Thumbnails', 'uk-portfolio' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $column_thumb + array_slice( $columns, 1, NULL, true );

		return $columns;

	}

	/**
	 * Display thumbnail.
	 *
	 * @since    1.1.2
	 */
	public function display_thumbnail( $column ) {

		global $post;

		switch ( $column ) {
			case 'uk-project_thumbnail':
				echo get_the_post_thumbnail( absint( $post->ID ), array( 48, 48 ) );
				break;
		}

	}

	/**
	 * Add taxonomy filters to the admin page.
	 *
	 * @since    1.1.2
	 */
	public function add_taxonomy_filters() {

		global $typenow;

		if ( 'uk-project' !== $typenow ) {
			return;
		}

		// Use taxonomy name or slug
		$taxonomies = array( 'uk-project_category', 'uk-project_tag' );

		// Post type for the filter
		foreach ( $taxonomies as $tax_slug ) {
			$terms = get_terms( $tax_slug );

			if ( 0 == count( $terms ) ) {
				return;
			}

			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;

			$current_tax_slug = isset( $_GET[ $tax_slug ] ) ? sanitize_text_field( $_GET[ $tax_slug ] ) : false;

			$filter = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			$filter .= '<option value="">' . esc_html( $tax_name ) . '</option>';
			foreach ( $terms as $term ) {
				$filter .= sprintf(
					'<option value="%1$s" %2$s />%3$s</option>',
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug, false ),
					esc_html( $term->name . ' (' . $term->count . ')' )
				);
			}
			$filter .= '</select>';

			echo wp_kses(
				$filter,
				array(
					'select' => array(
						'name'  => array(),
						'id' 	=> array(),
						'class' => array()
					),
					'option' => array(
						'value' 	=> array(),
						'selected' 	=> array()
					)
				)
			);
		}

	}

	/**
	 * Add count to "Right Now" dashboard widget.
	 *
	 * @since    1.1.2
	 */
	public function add_projects_count() {

		if ( ! post_type_exists( 'uk-project' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'uk-project' );

		if ( $num_posts && $num_posts->publish ) {
			$text = esc_html( _nx( '%s Project', '%s Projects', $num_posts->publish, 'Number of projects', 'uk-portfolio' ) );

			$text = sprintf( $text, number_format_i18n( $num_posts->publish ) );
			$post_type_object = get_post_type_object( 'uk-project' );

			if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
				printf( '<li class="projects-count"><a href="edit.php?post_type=uk-project">%s</a></li>', esc_html( $text ) );
			} else {
				printf( '<li class="projects-count"><span>%s</span></li>', esc_html( $text ) );
			}
		}

		if ( $num_posts && $num_posts->pending > 0 ) {
			$text = esc_html( _nx( '%s Project Pending', '%s Proects Pending', $num_posts->pending, 'Number of pending projects', 'uk-portfolio' ) );

			$text = sprintf( $text, number_format_i18n( $num_posts->pending ) );
			$post_type_object = get_post_type_object( 'uk-project' );

			if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
				printf( '<li class="projects-pending-count"><a href="edit.php?post_status=pending&post_type=uk-project">%s</a></li>', esc_html( $text ) );
			}
		}

	}

}
