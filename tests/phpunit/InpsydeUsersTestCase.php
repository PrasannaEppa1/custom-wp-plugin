<?php
use Brain\Monkey;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;


/**
 * An abstraction over WP_Mock to do things fast
 * It also uses the snapshot trait
 */
class InpsydeUsersTestCase extends PHPUnitTestCase {
	//use MatchesSnapshots;
	use MockeryPHPUnitIntegration;

	/**
	 * Set up the test fixtures
	 *
	 */
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
		// A few common passthrough
		// 1. WordPress i18n functions
		Monkey\Functions\when( '__' )
			->returnArg( 1 );
		Monkey\Functions\when( '_e' )
			->returnArg( 1 );
		Monkey\Functions\when( '_n' )
			->returnArg( 1 );
	}

	/**
	 * Teardown which calls \WP_Mock tearDown
	 *
	 * @return void
	 */
	public function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}
}