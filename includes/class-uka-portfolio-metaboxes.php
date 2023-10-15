<?php
/**
 * TThe class responsible for adding metaboxes
 *
 * @since      1.0.0
 *
 * @package    Uka_Portfolio
 * @subpackage Uka_Portfolio/includes
 */

class Uka_Portfolio_Metaboxes {

	/**
	 * Array of options for adding a metabox.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $options    Array of options for adding a metabox.
	 */
	protected $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $options = array() ) {
		$this->options = $options;
	}

	/**
	 * Add metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {

		if ( ! is_array( $this->options ) ) {
			return false;
		}

		foreach ( $this->options[ 'screen' ] as $screen ) {
			add_meta_box( $this->options[ 'id' ], $this->options[ 'title' ], array( $this, 'create_meta_boxes' ), $screen, $this->options[ 'context' ], $this->options[ 'priority' ] );
		}

	}

	/**
	 * Create metaboxes.
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The current post.
	 */
	public function create_meta_boxes() {

		if ( ! is_array( $this->options ) ) {
			return false;
		}

		global $post;

		wp_nonce_field( basename( __FILE__ ), 'uka_meta_box_wp_nonce' );

		echo '<table class="index-meta-table form-table"><tbody>';
		foreach ( $this->options[ 'fields' ] as $field ) {
			// Get data from post
			$meta = get_post_meta( $post->ID, $field[ 'id' ], true );

			echo '<tr><th><label for="' . $field[ 'id' ] . '" class="' . $field[ 'id' ] . '">' . $field[ 'name' ] . '</label></th>';

			switch ( $field[ 'type' ] ) {
				case 'text':
					echo '<td>';
					echo '<input type="text" id="' . $field[ 'id' ] . '" name="uka_meta[' . $field['id'] . ']" value="' . ( $meta ? $meta : $field[ 'std' ] ) . '" size="30" />';
					echo '<p class="description">' . $field['desc'] . '</p>';
					echo '</td>';
					break;

				case 'textarea':
					echo '<td>';
					echo '<textarea id="' . $field[ 'id' ] . '" name="uka_meta[' . $field['id'] . ']" rows="7" cols="5">' . ( $meta ? $meta : $field[ 'std' ] ) . '</textarea>';
					echo '<p class="description">' . $field[ 'desc' ] . '</p>';
					echo '</td>';
					break;

				case 'select':
					echo '<td>';
					echo '<select id="' . $field[ 'id' ] . '" name="uka_meta[' . $field['id'] . ']">';
					foreach ( $field[ 'options' ] as $key => $option ) {
						echo '<option value="' . $key . '"';
						if ( $meta ) {
							if ( $meta == $key ) {
								echo ' selected="selected"';
							}
						} else {
							if ( $field[ 'std' ] == $key ) {
								echo ' selected="selected"';
							}
						}
						echo '>' . $option . '</option>';
					}
					echo '</select>';
					echo '<p class="description">' . $field[ 'desc' ] . '</p>';
					echo '</td>';
					break;

				case 'radio':
					$i = 1;
					echo '<td>';
					echo '<ul class="radio-list">';
					foreach ( $field[ 'options' ] as $key => $option ) {
						echo '<li>';
						echo '<input type="radio" id="' . $field[ 'id' ] . $i . '" name="uka_meta[' . $field['id'] .']" value="' . $key . '"';
						if ( $meta ) {
							if ( $meta == $key ) {
								echo ' checked="checked"';
							}
						} else {
							if ( $field[ 'std' ] == $key ) {
								echo ' checked="checked"';
							}
						}
						echo ' /> ';
						echo '<label for="' . $field[ 'id' ] . $i . '">' . $option . '</label>';
						echo '</li>';
						$i++;
					}
					echo '</ul>';
					echo '<p class="description">' . $field[ 'desc' ] . '</p>';
					echo '</td>';
					break;

				case 'checkbox':
					echo '<td>';
					$val = '';
					if ( $meta ) {
						if ( $meta == 'on' ) {
							$val = ' checked="checked"';
						}
					} else {
						if ( $field[ 'std' ] == 'on' ) {
							$val = ' checked="checked"';
						}
					}
					echo '<input type="hidden" name="uka_meta[' . $field['id'] . ']" value="off" />
								<input type="checkbox" id="' . $field[ 'id' ] . '" name="uka_meta[' . $field['id'] . ']" value="on"' . $val . ' />
								<label for="' . $field[ 'id' ] . '">' . $field[ 'desc' ] . '</label>';
					echo '</td>';
					break;
			}
			echo '</tr>';
		}
		echo '</tbody></table>';

	}

	/**
	 * Save metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function save_meta_boxes( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST[ 'uka_meta' ] ) || ! isset( $_POST[ 'uka_meta_box_wp_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'uka_meta_box_wp_nonce' ], basename( __FILE__ ) ) ) {
			return;
		}

		if ( 'page' == $_POST[ 'post_type' ] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		foreach ( $_POST[ 'uka_meta' ] as $key => $val ) {
			update_post_meta( $post_id, $key, $val );
		}

	}

}
