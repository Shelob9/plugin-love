<?php


class Rating_Log {

	/**
	 * Name of option that hold the log
	 *
	 * @var string
	 */
	protected static $option_name = '_plugin_rating_prompts';

	/**
	 * Add all active plugins to log
	 */
	public static function add_all() {
		$plugins = get_plugins();
		if( ! empty( $plugins ) ) {
			$log = self::get();
			foreach( $plugins as $path => $data ) {
				$log[ $path ] = self::prepare( $path );
			}

			update_option( self::$option_name, $log );
		}

	}

	/**
	 * Get the log
	 *
	 * @return array
	 */
	public static function get() {
		return get_option( self::$option_name, array() );
	}

	/**
	 * Add one plugin to the log
	 *
	 * @param string $path Plugin path.
	 */
	public static function add( $path ) {
		$log = self::get();

		$log[ $path ] = self::prepare( $path );
		update_option( self::$option_name, $log );

	}

	/**
	 * Remove a plugin from the log
	 *
	 * @param string $path Plugin path.
	 */
	public static function remove( $path ) {
		$log = self::get();
		if( ! empty( $log ) && array_key_exists( $path, $log ) ) {
			unset( $log[ $path ] );
			update_option( self::$option_name, $log );

		}

	}

	/**
	 * Mark a plugin as being activated
	 *
	 * @param string $path Plugin path.
	 */
	public static function mark( $path  ) {
		$log = self::get();
		if( ! empty( $log ) && array_key_exists( $path, $log ) ) {
			$log[ $path ][ 'acted_on' ] = true;
			update_option( self::$option_name, $log );
		}

	}

	/**
	 * @param string $path Plugin path.
	 *
	 * @return bool|string|null
	 */
	public static function acted_on( $path ) {
		$log = self::get();
		if( ! empty( $log ) && array_key_exists( $path, $log ) ) {
			return $log[ $path ][ 'acted_on' ];

		}

		return null;
	}

	/**
	 * Prepare array of data for a plugin to save in log
	 *
	 * @param string $path Plugin path.
	 *
	 * @return array
	 */
	 protected static function prepare( $path ) {
		$data = array(
			'path'            => $path,
			'activation_time' => time(),
			'acted_on'        => false,

		);

		return $data;
	}

}
