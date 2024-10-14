<?php
namespace JW\Core;

/**
 * Base Registry Trait
 */
trait Base {

	/**
	 * Variable that holds all objects in registry.
	 *
	 * @var array
	 */
	protected static $stored_objects = [];

	/**
	 * Add object to registry
	 */
	public static function set( $key, $value ) {
		if ( ! is_string( $key ) ) {
			trigger_error( __( 'Error in the key passed to "set"', 'jwstore-core' ), E_USER_ERROR );
		}
		static::$stored_objects[ $key ] = $value;

	}

	/**
	 * Get object from registry
	 */
	public static function get( $key ) {
		if ( ! is_string( $key ) ) {
			trigger_error( __( 'Error in the key passed to "get"', 'jwstore-core' ), E_USER_ERROR );
		}

		if ( ! isset( static::$stored_objects[ $key ] ) ) {
			return null;
		}

		return static::$stored_objects[ $key ];
	}

	/**
	 * Returns all objects
	 */
	public static function get_all_objects() {
		return static::$stored_objects;
	}
}
