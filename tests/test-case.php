<?php


class plugin_love_test_case extends WP_UnitTestCase {

	public function setUp(){
		parent::setUp();

		update_option( 'active_plugins', array() );
		$fake_plugins = $this->mock_plugin_paths();
		foreach( $fake_plugins as $path ) {
			activate_plugin( $path );
		}

	}



	public function tearDown(){
		parent::tearDown();

		update_option( '_plugin_rating_prompts', array() );

	}


	/**
	 * Paths to fake plugins used in tests
	 *
	 * @return array
	 */
	protected function mock_plugin_paths() {
		$path =  basename( dirname( dirname( __FILE__ ) ) );

		$plugins = array(
			$path . '/tests/fake-one.php',
			$path . '/tests/fake-two.php'
		);


		return $plugins;
	}
}

