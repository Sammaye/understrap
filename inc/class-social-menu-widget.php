<?php
class Social_Menu_Widget extends WP_Widget {

	public function __construct( string $id_base = '', string $name = '', array $widget_options = array(), array $control_options = array() ) {
		$widget_options = array(
			'classname' => 'social_menu_widget',
			'description' => __('Social menu for the current theme', 'understrap'),
		);
		parent::__construct( 'Social_Menu_Widget', 'Social Menu Widget', $widget_options, $control_options );
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		wp_nav_menu( array(
			'theme_location' => 'social',
			'menu_class'     => 'social-links-menu',
			'link_before'    => '<span class="sr-only">',
			'link_after'     => '</span>',
			'depth'          => 1,
		) );
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'understrap' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'understrap' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}
}
