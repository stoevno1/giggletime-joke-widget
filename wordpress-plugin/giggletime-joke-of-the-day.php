<?php
/**
 * Plugin Name:       GiggleTime Joke of the Day
 * Plugin URI:        https://www.giggletime.app/en/widget
 * Description:       A free, family-friendly joke of the day for your site, in 26 languages. Add it with a block, a sidebar widget or the [giggletime_joke] shortcode. No cookies, no tracking.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Author:            GiggleTime
 * Author URI:        https://www.giggletime.app/
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       giggletime-joke-of-the-day
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GTJOTD_VERSION', '1.0.0' );
define( 'GTJOTD_EMBED_URL', 'https://www.giggletime.app/embed/joke' );

/** Languages the widget offers (code => native name). */
function gtjotd_languages() {
	return array(
		'en' => 'English',
		'ar' => 'العربية',
		'bg' => 'Български',
		'ca' => 'Català',
		'cs' => 'Čeština',
		'cy' => 'Cymraeg',
		'da' => 'Dansk',
		'de' => 'Deutsch',
		'el' => 'Ελληνικά',
		'es' => 'Español',
		'et' => 'Eesti',
		'fr' => 'Français',
		'hi' => 'हिन्दी',
		'id' => 'Bahasa Indonesia',
		'it' => 'Italiano',
		'ja' => '日本語',
		'ka' => 'ქართული',
		'nl' => 'Nederlands',
		'pl' => 'Polski',
		'pt' => 'Português',
		'ru' => 'Русский',
		'sv' => 'Svenska',
		'tr' => 'Türkçe',
		'uk' => 'Українська',
		'vi' => 'Tiếng Việt',
		'zh' => '中文',
	);
}

/** Joke categories (slug => English name). An empty slug means all categories. */
function gtjotd_categories() {
	return array(
		''               => __( 'All categories', 'giggletime-joke-of-the-day' ),
		'animals'        => __( 'Animals', 'giggletime-joke-of-the-day' ),
		'christmas'      => __( 'Christmas', 'giggletime-joke-of-the-day' ),
		'everyday-life'  => __( 'Everyday life', 'giggletime-joke-of-the-day' ),
		'family'         => __( 'Family', 'giggletime-joke-of-the-day' ),
		'food-and-drink' => __( 'Food and drink', 'giggletime-joke-of-the-day' ),
		'school'         => __( 'School', 'giggletime-joke-of-the-day' ),
		'money'          => __( 'Money', 'giggletime-joke-of-the-day' ),
		'programming'    => __( 'Programming', 'giggletime-joke-of-the-day' ),
		'pun'            => __( 'Puns', 'giggletime-joke-of-the-day' ),
		'spooky'         => __( 'Spooky', 'giggletime-joke-of-the-day' ),
		'technology'     => __( 'Technology', 'giggletime-joke-of-the-day' ),
		'work'           => __( 'Work', 'giggletime-joke-of-the-day' ),
		'misc'           => __( 'Miscellaneous', 'giggletime-joke-of-the-day' ),
	);
}

/** Heights in pixels for each size. */
function gtjotd_heights() {
	return array( 's' => 160, 'm' => 200, 'l' => 260 );
}

/** Cleans settings coming from a shortcode, block or widget. */
function gtjotd_normalize( $args ) {
	$args = wp_parse_args(
		(array) $args,
		array(
			'lang'        => '',
			'category'    => '',
			'theme'       => 'auto',
			'size'        => 'm',
			'attribution' => '',
		)
	);
	$lang = strtolower( (string) $args['lang'] );
	if ( '' === $lang ) {
		// Default to the site's own language when the widget has it.
		$lang = strtolower( substr( (string) get_locale(), 0, 2 ) );
	}
	if ( ! array_key_exists( $lang, gtjotd_languages() ) ) {
		$lang = 'en';
	}
	$category = strtolower( (string) $args['category'] );
	if ( ! array_key_exists( $category, gtjotd_categories() ) ) {
		$category = '';
	}
	$theme = in_array( $args['theme'], array( 'auto', 'light', 'dark' ), true ) ? $args['theme'] : 'auto';
	$size  = array_key_exists( $args['size'], gtjotd_heights() ) ? $args['size'] : 'm';

	// The credit link is off unless the site owner turns it on.
	$attribution = $args['attribution'];
	$attribution = ( true === $attribution || '1' === (string) $attribution || 'yes' === $attribution || 'true' === $attribution );

	return array(
		'lang'        => $lang,
		'category'    => $category,
		'theme'       => $theme,
		'size'        => $size,
		'attribution' => $attribution,
	);
}

/** The widget's HTML: an iframe, plus the optional credit line. */
function gtjotd_render( $args ) {
	$o     = gtjotd_normalize( $args );
	$query = array( 'lang' => $o['lang'] );
	if ( '' !== $o['category'] ) {
		$query['cat'] = $o['category'];
	}
	if ( 'auto' !== $o['theme'] ) {
		$query['theme'] = $o['theme'];
	}
	if ( 'm' !== $o['size'] ) {
		$query['size'] = $o['size'];
	}
	$heights = gtjotd_heights();
	$src     = add_query_arg( $query, GTJOTD_EMBED_URL );

	$html = sprintf(
		'<iframe src="%s" title="%s" width="100%%" height="%d" loading="lazy" style="border:0;display:block;max-width:100%%"></iframe>',
		esc_url( $src ),
		esc_attr__( 'Joke of the Day', 'giggletime-joke-of-the-day' ),
		(int) $heights[ $o['size'] ]
	);
	if ( $o['attribution'] ) {
		$html .= sprintf(
			'<p class="gtjotd-credit" style="font-size:.85em;margin:.4em 0 0">%s <a href="%s">GiggleTime</a></p>',
			esc_html__( 'Joke of the day by', 'giggletime-joke-of-the-day' ),
			esc_url( 'https://www.giggletime.app/' . $o['lang'] . '/home' )
		);
	}
	return '<div class="gtjotd-widget">' . $html . '</div>';
}

/* Shortcode: [giggletime_joke lang="es" category="animals" theme="dark" size="l" attribution="yes"] */
function gtjotd_shortcode( $atts ) {
	return gtjotd_render( shortcode_atts( array(
		'lang'        => '',
		'category'    => '',
		'theme'       => 'auto',
		'size'        => 'm',
		'attribution' => '',
	), $atts, 'giggletime_joke' ) );
}
add_shortcode( 'giggletime_joke', 'gtjotd_shortcode' );

/* Block: rendered on the server, so the editor preview and the page are the same. */
function gtjotd_register_block() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	wp_register_script(
		'gtjotd-block-editor',
		plugins_url( 'block.js', __FILE__ ),
		array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-server-side-render', 'wp-i18n' ),
		GTJOTD_VERSION,
		true
	);
	$options = array( 'languages' => array(), 'categories' => array() );
	foreach ( gtjotd_languages() as $code => $name ) {
		$options['languages'][] = array( 'value' => $code, 'label' => $name );
	}
	foreach ( gtjotd_categories() as $slug => $name ) {
		$options['categories'][] = array( 'value' => $slug, 'label' => $name );
	}
	wp_add_inline_script( 'gtjotd-block-editor', 'window.gtjotdOptions = ' . wp_json_encode( $options ) . ';', 'before' );
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'gtjotd-block-editor', 'giggletime-joke-of-the-day' );
	}

	register_block_type( 'giggletime/joke-of-the-day', array(
		'api_version'     => 2,
		'editor_script'   => 'gtjotd-block-editor',
		'render_callback' => 'gtjotd_render',
		'attributes'      => array(
			'lang'        => array( 'type' => 'string', 'default' => '' ),
			'category'    => array( 'type' => 'string', 'default' => '' ),
			'theme'       => array( 'type' => 'string', 'default' => 'auto' ),
			'size'        => array( 'type' => 'string', 'default' => 'm' ),
			'attribution' => array( 'type' => 'boolean', 'default' => false ),
		),
	) );
}
add_action( 'init', 'gtjotd_register_block' );

/* Classic sidebar widget. */
class GTJOTD_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'gtjotd_widget',
			__( 'GiggleTime Joke of the Day', 'giggletime-joke-of-the-day' ),
			array( 'description' => __( 'A new family-friendly joke every day.', 'giggletime-joke-of-the-day' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme markup
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . esc_html( apply_filters( 'widget_title', $instance['title'] ) ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		echo gtjotd_render( $instance ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in gtjotd_render()
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$o     = gtjotd_normalize( $instance );
		$this->text_field( 'title', __( 'Title (optional)', 'giggletime-joke-of-the-day' ), $title );
		$this->select_field( 'lang', __( 'Language', 'giggletime-joke-of-the-day' ), gtjotd_languages(), $o['lang'] );
		$this->select_field( 'category', __( 'Category', 'giggletime-joke-of-the-day' ), gtjotd_categories(), $o['category'] );
		$this->select_field( 'theme', __( 'Theme', 'giggletime-joke-of-the-day' ), array(
			'auto'  => __( 'Auto (follows the visitor\'s light or dark mode)', 'giggletime-joke-of-the-day' ),
			'light' => __( 'Light', 'giggletime-joke-of-the-day' ),
			'dark'  => __( 'Dark', 'giggletime-joke-of-the-day' ),
		), $o['theme'] );
		$this->select_field( 'size', __( 'Size', 'giggletime-joke-of-the-day' ), array(
			's' => __( 'Small', 'giggletime-joke-of-the-day' ),
			'm' => __( 'Medium', 'giggletime-joke-of-the-day' ),
			'l' => __( 'Large', 'giggletime-joke-of-the-day' ),
		), $o['size'] );
		$id = $this->get_field_id( 'attribution' );
		printf(
			'<p><input type="checkbox" class="checkbox" id="%1$s" name="%2$s" value="1" %3$s> <label for="%1$s">%4$s</label></p>',
			esc_attr( $id ),
			esc_attr( $this->get_field_name( 'attribution' ) ),
			checked( $o['attribution'], true, false ),
			esc_html__( 'Show a "Joke of the day by GiggleTime" link under the joke', 'giggletime-joke-of-the-day' )
		);
	}

	public function update( $new_instance, $old_instance ) {
		$o          = gtjotd_normalize( $new_instance );
		$o['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : '' );
		return $o;
	}

	private function text_field( $field, $label, $value ) {
		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" type="text" id="%1$s" name="%3$s" value="%4$s"></p>',
			esc_attr( $this->get_field_id( $field ) ),
			esc_html( $label ),
			esc_attr( $this->get_field_name( $field ) ),
			esc_attr( $value )
		);
	}

	private function select_field( $field, $label, $choices, $value ) {
		printf( '<p><label for="%1$s">%2$s</label><select class="widefat" id="%1$s" name="%3$s">', esc_attr( $this->get_field_id( $field ) ), esc_html( $label ), esc_attr( $this->get_field_name( $field ) ) );
		foreach ( $choices as $key => $name ) {
			printf( '<option value="%s" %s>%s</option>', esc_attr( $key ), selected( $value, $key, false ), esc_html( $name ) );
		}
		echo '</select></p>';
	}
}

function gtjotd_register_widget() {
	register_widget( 'GTJOTD_Widget' );
}
add_action( 'widgets_init', 'gtjotd_register_widget' );
