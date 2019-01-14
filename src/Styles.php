<?php 
namespace RD\WP;

class Styles {
	protected static $_base = null;
	protected static $_css = null;
	protected static $_class = null;
	protected static $_state = [];
	protected static $_css_instance = null;
	

	/**
	 * Save current state
	 *
	 * @return void
	 */
	public static function save_state(){
		$state = [
			'base' => self::$_base,
			'class' => self::$_class,
		];
		array_unshift( self::$_state, $state );
	}

	/**
	 * Restore last state
	 *
	 * @return void
	 */
	public static function done(){
		if ( ! empty( self::$_state ) ) {
			$state = self::$_state[0];
			self::$_base = $state['base'];
			self::$_class = $state['class'];
		}
	}

	/**
	 * Generate class name
	 *
	 * @return string
	 */
	public static function generate_class(){
		$prefix = "rd-dynamic-";
		$length = 8;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $prefix . $randomString;
	}

	/**
	 * Create a new dynamic css rule
	 *
	 * @param string $base
	 * @return \RD\WP\CSS_Rule
	 */
	public static function init( $base = '' ){
		self::save_state();
		self::$_class = self::generate_class();
		self::$_base = \sprintf( '.%s%s', self::$_class, $base );
	}

	/**
	 * Get CSS instance
	 *
	 * @return CSS
	 */
	public static function get_css(){
		if ( ! self::$_css_instance ) {
			self::$_css_instance = new \RD\WP\CSS();
		}
		return self::$_css_instance;
	}
	/**
	 * Add new rule
	 *
	 * @param string $selector
	 * @return \RD\WP\CSS_Rule
	 */
	public static function add_rule( $selector = null ){
		$base = self::$_base;
		if ( $base == null ) {
			throw new \Exception( 'You must use init function first.' );
		}
		if ( $selector ) {
			$base = $base . ' ' . $selector;
		}
		return self::get_css()->add_rule( $base );
	}


	/**
	 * Get base class
	 *
	 * @return void
	 */
	public static function class() {
		if ( self::$_class == null ) {
			throw new \Exception( 'You must use init function first.' );
		}
		return self::$_class;
	}

	/**
	 * Print dynamic css
	 *
	 * @return void
	 */
	public static function print_dynamic_css(){
		echo self::get_css()->styles();
	}


	public static function instance(){
		add_action( 'wp_footer', array(__CLASS__, 'print_dynamic_css') );
	}

}

Styles::instance();