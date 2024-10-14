<?php
namespace JW\Core;

/**
 * Abstract class to define/implement base methods for model classes
 */
class Model {
	use base;

	/**
	 * Provides access to a single instance of a module.
	 *
	 * @return object
	 */
	public static function get_instance() {
		$classname = get_called_class();
		$instance = self::get( $classname );

		if ( null === $instance ) {
			$instance = new $classname();
			self::set( $classname, $instance );
		}

		return $instance;
	}

}
