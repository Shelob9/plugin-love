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
	public function __construct(){
		$this->set_possible();

	}

	/**
	 * @return array Data for chosen plugin or null if there are no possibilities chosen
	 */
	public function get_chosen_plugin(){
		return $this->chosen_plugin;
	}

	/**
	 *
	 * @return array Log of plugins to choose from
	 */
	protected function set_possible(){
		$this->possible = Rating_Log::get();
	}

	/**
	 * Run plugin chooser if there are possible plugins to choose from.
	 */
	protected function choose(){
		if ( ! empty( $this->possible ) ){
			$this->choose();
		} else {
			Rating_Log::add_all();
			$this->set_possible();

			if ( ! empty( $this->possible ) ){
				$this->choose();
			}
		}
	}

	/**
	 *
	 * @return array Plugin data for chosen plugin. Accessible via the public get_chosen_plugin() method.
	 */
	protected function choose_plugin() {
		$key = array_rand( $this->possible );
		$_chosen = $this->possible[$key];
		$active = is_plugin_active( $_chosen );
		if ( $active ) {
			$this->chosen_plugin = get_plugin_data( $_chosen['path'] );
		} else {
			Rating_Log::remove( $_chosen );
			$this->set_possible();
			$this->choose();
		}
	}

	protected function valid_choice( $chosen ) {
		// TODO
	}
}
