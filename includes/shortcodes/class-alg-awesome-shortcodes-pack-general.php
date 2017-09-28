<?php
/**
 * Awesome Shortcodes - Shortcode Packs - General
 *
 * @version 1.0.1
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Alg_Awesome_Shortcodes_Pack_General' ) ) :

class Alg_Awesome_Shortcodes_Pack_General extends Alg_Abstract_Awesome_Shortcodes_Pack {

	/**
	 * Constructor.
	 *
	 * @version 1.0.1
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id         = 'general';
		$this->desc       = __( 'General', 'awesome-shortcodes' );
		$this->shortcodes = array(
			'timenow' => array(
				'desc'             => __( 'Shows current time in <code>HH:MM:SS</code> format. Updated every second.', 'awesome-shortcodes' ),
				'type'             => 'self-closing',
				'aliases'          => array( 'clock' ),
				'enqueue_scripts'  => array( array( 'src' => 'js/timenow.js', 'deps' => array( 'jquery' ) ) ),
				'examples'         => array( array() ),
			),
			'countdown' => array(
				'desc'             => __( 'Creates a countdown timer. Updated every second.', 'awesome-shortcodes' ),
				'type'             => 'self-closing',
				'aliases'          => array( 'timer' ),
				'enqueue_scripts'  => array( array( 'src' => 'js/countdown.js' ) ),
				'atts'             => array(
					'date_to' => array(
						'default'  => '',
						'desc'     => __( 'Date we\'re counting down to. E.g.: <code>2021/01/01 12:00</code>.', 'awesome-shortcodes' ),
						'required' => true,
					),
				),
				'examples'         => array(
					array(
						'atts'    => array( 'date_to' => '2021/01/01 12:00' )
					),
				),
			),
			'hide' => array(
				'desc'             => __( 'Hides content. Useful for commenting.', 'awesome-shortcodes' ),
				'type'             => 'enclosing',
				'aliases'          => array( 'comment' ),
				'examples'         => array(
					array(
						'content' => __( 'This text will be hidden.', 'awesome-shortcodes' ),
					),
				),
			),
			'table' => array(
				'desc'             => __( 'Displays HTML table.', 'awesome-shortcodes' ),
				'type'             => 'enclosing',
				'examples'         => array(
					array(
						'content' => 'row_1 cell_1,row_1 cell_2|row_2 cell_1,row_2 cell_2',
					)
				),
				'atts'             => array(
					'table_class' => array(
						'default'  => '',
						'desc'     => __( 'Table CSS class.', 'awesome-shortcodes' ),
					),
					'table_heading_type' => array(
						'default'  => 'horizontal',
						'desc'     => sprintf( __( 'Table heading type. Possible values: %s.', 'awesome-shortcodes' ),
							'<code>' . implode( '</code>, <code>', array( 'horizontal', 'vertical', 'none' ) ) . '</code>' ),
					),
				),
			),
			'posts' => array(
				'desc'             => __( 'Displays posts.', 'awesome-shortcodes' ),
				'type'             => 'self-closing',
				'examples'         => array( array() ),
			),
			'date' => array(
				'desc'             => __( 'Displays current date.', 'awesome-shortcodes' ),
				'type'             => 'self-closing',
				'atts'             => array(
					'date_format' => array(
						'default'  => 'Y-m-d',
						'desc'     => __( 'Date format. As in PHP <code>date</code> function (<a target="_blank" href="http://php.net/manual/en/function.date.php">http://php.net/manual/en/function.date.php</a>).', 'awesome-shortcodes' ),
					),
				),
				'examples'         => array(
					array(
						'atts'    => array(
							'date_format' => 'Y',
							'before'      => '&copy; ',
							'after'       => '. All Rights Reserved.',
						),
					),
				),
			),
		);
		parent::__construct();
	}

	/**
	 * timenow.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    (maybe) more atts. E.g.: `time_format`, `update_period`, styling options etc.
	 */
	function timenow( $atts, $content, $tag ) {
		return '<p class="awesome-shortcode-timenow"></p>';
	}

	/**
	 * countdown.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    (maybe) more atts. E.g.: `countdown_format`, `update_period`, `on_expired`, styling options etc.
	 */
	function countdown( $atts, $content, $tag ) {
		return ( ! empty( $atts['date_to'] ) ? '<p class="awesome-shortcode-countdown" date-to="' . $atts['date_to'] . '"></p>' : '' );
	}

	/**
	 * date.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function date( $atts, $content, $tag ) {
		return date( $atts['date_format'] );
	}

	/**
	 * hide.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function hide( $atts, $content, $tag ) {
		return '';
	}

	/**
	 * posts.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    (maybe) more atts
	 */
	function posts( $atts, $content, $tag ) {
		return implode( '<br>', alg_awesome_shortcodes_get_posts() );
	}

	/**
	 * table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @todo    (maybe) more atts. E.g.: `row_sep`, `cell_sep` etc.
	 */
	function table( $atts, $content, $tag ) {
		$table_data = array();
		$rows       = explode( '|', $content );
		foreach ( $rows as $row ) {
			$table_data[] = explode( ',', $row );
		}
		return alg_awesome_shortcodes_get_table_html( $table_data, array( 'table_class' => $atts['table_class'], 'table_heading_type' => $atts['table_heading_type'] ) );
	}

}

endif;

return new Alg_Awesome_Shortcodes_Pack_General();
