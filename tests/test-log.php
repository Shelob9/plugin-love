<?php

class test_rating_log extends plugin_love_test_case {

	/**
	 * @group now
	 */
	public function testFakePluginsActive() {
		$fake_plugins = $this->mock_plugin_paths();
		foreach ( $fake_plugins as $path ) {
			$this->assertTrue( is_plugin_active( $path ), $path );
		}

	}

	/**
	 * @covers Rating_Log::get()
	 */
	public function testAddAll() {
		$plugins = $this->mock_plugin_paths();
		update_option( 'active_plugins', $plugins );
		$log = Rating_Log::get();
		$this->assertFalse( empty( $log ) );
		$this->assertArrayHasKey( 'tests/fake-one.php', $log );
		$this->assertArrayHasKey( 'tests/fake-two.php', $log );
	}

	/**
	 * @covers Rating_Log::add_all()
	 */
	public function testAddToLog() {
		Rating_Log::add( 'tests/fake-one.php' );
		$log = Rating_Log::get();
		$this->assertArrayHasKey( 'tests/fake-one.php', $log );

	}


	/**
	 *
	 * @covers Rating_Log::read()
	 * @covers Rating_Log::prepare()
	 */
	public function testData() {
		$plugins = $this->mock_plugin_paths();
		update_option( 'active_plugins', $plugins );
		$log = Rating_Log::get();
		foreach ( $log as $path => $data ) {
			$this->assertArrayHasKey( 'path', $data );
			$this->assertSame( $path, $data[ 'path' ] );
			$this->assertTrue( in_array( $data[ 'path' ], array(
				'tests/fake-one.php',
				'tests/fake-two.php'
			) ) );
			$this->assertArrayHasKey( 'activation_time', $data );
			$this->assertInternalType( 'int', $data[ 'activation_time' ] );
			$this->assertArrayHasKey( 'acted_on', $data );
			$this->assertFalse( $data[ 'acted_on' ] );
		}

	}


	/**
	 * @covers Rating_Log::mark()
	 */
	public function testMarkAsActedOn() {
		$plugins = $this->mock_plugin_paths();
		update_option( 'active_plugins', $plugins );

		Rating_Log::mark( 'tests/fake-one.php' );
		$log = Rating_Log::get();
		$this->assertTrue( $log[ 'tests/fake-one.php' ][ 'acted_on' ] );
		$this->assertFalse( $log[ 'tests/fake-two.php' ][ 'acted_on' ] );

	}

	/**
	 *
	 * @covers Rating_Log::acted_on()
	 */
	public function testActedOn() {
		$plugins = $this->mock_plugin_paths();
		update_option( 'active_plugins', $plugins );

		Rating_Log::mark( 'tests/fake-one.php' );

		$this->assertTrue( Rating_Log::acted_on( 'tests/fake-one.php' ) );
		$this->assertFalse( Rating_Log::acted_on( 'tests/fake-two.php' ) );

	}

}

