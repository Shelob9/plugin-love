<?php
class test_choice extends plugin_love_test_case {

	public function setUp(){
		parent::setUp();
		Rating_Log::add_all();
	}

	/**
	 * Test that an active plugin, that has been activated long enough IS considered valid
	 *
	 * @covers Rating_Choice::valid_choice()
	 */
	public function testChoiceValid(){
		$activated = time() - 16 * DAY_IN_SECONDS;
		$plugin = array(
			'path'            => 'tests/fake-one.php',
			'activation_time' => $activated,
			'acted_on'        => false,
		);

		$chooser = new Rating_Choice();
		$this->assertTrue( $chooser->valid_choice( $plugin ) );

	}

	/**
	 * Test that an non-existent plugin, that has been activated long enough (as far as log is concerned) IS NOT considered valid
	 *
	 * @covers Rating_Choice::valid_choice()
	 */
	public function testChoiceNotActive(){
		$activated = time() - 16 * DAY_IN_SECONDS;
		$plugin = array(
			'path'            => 'tests/fake-four.php',
			'activation_time' => $activated,
			'acted_on'        => false,
		);

		$chooser = new Rating_Choice();
		$this->assertFalse( $chooser->valid_choice( $plugin ) );

	}

	/**
	 * Test that an active plugin, that has not been activate long enough IS NOT considered valid
	 *
	 * @covers Rating_Choice::valid_choice()
	 */
	public function testChoiceTooSoon(){
		$activated = time() - 6 * DAY_IN_SECONDS;
		$plugin = array(
			'path'            => 'tests/fake-one.php',
			'activation_time' => $activated,
			'acted_on'        => false,
		);

		$chooser = new Rating_Choice();
		$this->assertFalse( $chooser->valid_choice( $plugin ) );
	}

	/**
	 * Test that no plugin is chosen when a
	 *
	 * @covers Rating_Choice::get_chosen_plugin()
	 */
	public function testChooseShouldBeEmpty(){
		$chooser = new Rating_Choice();
		$chosen = $chooser->get_chosen_plugin();
		$this->assertTrue( empty( $chosen ) );

	}

	/**
	 * Test that one of the valid options is chosen
	 *
	 * @covers Rating_Choice::get_chosen_plugin()
	 */
	public function testChoose(){
		$past = time() - 20 * DAY_IN_SECONDS;

		//fake activation time
		$plugins = get_option( '_plugin_rating_prompts' );
		foreach( $plugins as $path => $plugin ) {
			$plugins[$path]['activated'] = $past;
		}

		$chooser = new Rating_Choice();
		$chosen = $chooser->get_chosen_plugin();
		$this->assertTrue( is_array( $chosen ) );
		$this->assertFalse( empty( $chosen ) );
		$this->assertSame( 'pluginlovetestgetsactivated', $chosen['Description'] );

	}

}
