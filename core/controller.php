<?php
namespace JW\Core;

/**
 * Abstract class to define/implement base methods for all controller classes
 */
abstract class Controller {
	use Base;

	/**
	 * Holds Model object
	 *
	 * @var Object
	 */
	protected $model;

	/**
	 * Holds View Object
	 *
	 * @var Object
	 */
	protected $view;

    protected function __construct( Model $model, $view = false ) {
        $this->internal_init( $model, $view );
    }

	/**
	 * Provides access to a single instance of a module using the singleton pattern
	 *
	 * @return object
	 */
	public static function get_instance( $model_class_name = false, $view_class_name = false, $config = false) {
		$classname = get_called_class();
		$key_in_registry = self::get_key( $classname, $model_class_name, $view_class_name );

		$instance = self::get( $key_in_registry );

		// Pass config to our MVC
		if ( false != $config ) {
			require_once( JW_CORE_DIR . 'config/' . $config . '.php' );
		}

		// Create a object if no object is found.
		if ( null === $instance ) {

			// Decide model to be passed to the constructor.
			if ( false != $model_class_name ) {
				$model = $model_class_name::get_instance();
			} else {
				$model = new Model();
			}

			// Decide view to be passed to the constructor.
			if ( false != $view_class_name ) {
				$view = new $view_class_name();
			} else {
				$view = new View();
			}

			$instance = new $classname( $model, $view );

			self::set( $key_in_registry, $instance );
		}

		return $instance;
	}

	/**
	 * Returns key used to store a particular Controller Object
	 *
	 * @return string
	 */
	public static function get_key( $controller_class_name, $model_class_name, $view_class_name ) {
		return "{$controller_class_name}__{$model_class_name}__{$view_class_name}";
	}

	/**
	 * Get model.
	 */
	protected function get_model() {
		return $this->model;
	}

	/**
	 * Get view
	 */
	protected function get_view() {
		return $this->view;
	}

	/**
	 * Sets the model to be used
	 */
	protected function set_model( Model $model ) {
		$this->model = $model;
	}

	/**
	 * Sets the view to be used
	 */
	protected function set_view( View $view ) {
		$this->view = $view;
	}

	/**
	 * Sets Model & View to be used with current controller
	 *
	 * @return void
	 */
	final protected function internal_init( Model $model, $view = false ) {
		$this->set_model( $model );

		if ( false === $view ) {
			$view = new View();
		}

		$this->set_view( $view );
	}
}