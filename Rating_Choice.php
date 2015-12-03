<?php

class Rating_Choice {

	/**
	 * Chosen plugin data
	 *
	 * @var array
	 */
	protected $chosen_plugin;

	/**
	 * Possible plugins
	 *
	 * @var array
	 */
	protected $possible;

	/**
	 * Construct object and choose a plugin if possible
	 */
	public function __construct() {
		$this->set_possible();
		$this->choose();
	}

	/**
	 * @return array Data for chosen plugin or null if there are no possibilities chosen
	 */
	public function get_chosen_plugin() {
		if ( is_null( $this->chosen_plugin ) ) {
			$this->choose();
		}

		return $this->chosen_plugin;
	}

	/**
	 *
	 * @return array Log of plugins to choose from
	 */
	protected function set_possible() {
		$this->possible = Rating_Log::get();
	}

	/**
	 * Run plugin chooser if there are possible plugins to choose from.
	 */
	protected function choose() {
		if ( ! empty( $this->possible ) ) {
			$key = array_rand( $this->possible );
			$_chosen = $this->possible[$key];
			if ( $this->valid_choice( $_chosen ) ) {
				$this->chosen_plugin = get_plugin_data( $_chosen['path'] );
				return;
			} else {
				unset( $this->possible[$_chosen] );
				$this->choose();
 			}

		}

	}


	/**
	 * Determine if chosen plugin is a valid choice
	 *
	 * Plugin mus be activated and have been active for 15 days
	 *
	 * @param array $chosen
	 *
	 * @return bool
	 */
	protected function valid_choice( $chosen ) {
		if( is_plugin_active( $chosen['path'] ) ) {
			$interval = apply_filters( 'plugin_love_interval', 15 * DAY_IN_SECONDS );
			$long_enough = $chosen['activated'] - $interval;
			if( time() > $long_enough ) {
				return true;

			}

		}
	}
}
