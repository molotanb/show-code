<?php
namespace JW\Core;

use JW;

/**
 * Class Responsible for Loading Templates
 */
class View {
	
	/**
	 * Render Templates
	 *
	 * @access public
	 * @return void
	 */
	public static function render_template( $template_name, $args = array(), $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args );
		}

		$located = static::locate_template( $template_name, $default_path );

		if ( false == $located ) {
			return;
		}

		ob_start();
		do_action( 'jw_core_before_template_render', $template_name, $located, $args );
		include( $located );
		do_action( 'jw_core_after_template_render', $template_name, $located, $args );

		return ob_get_clean();
	}

	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * @access public
	 * @return string
	 */
	public static function locate_template( $template_name, $default_path = '' ) {

		if ( ! $default_path ) {
			$default_path = JW_CORE_DIR . 'templates/';
		}

		$template = locate_template(
			array(
				$default_path . $template_name,
				$template_name,
			)
		);

		// Get default template.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		if ( file_exists( $template ) ) {
			// Return what we found.
			return apply_filters( 'jw_core_locate_template', $template, $template_name );
		} else {
			return false;
		}
	}
}
