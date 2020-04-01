<?php
namespace InpsydeUsersClass\Test;
use \Brain\Monkey\Functions;
use Inpsyde_Users;

class InpsydeUsersClassTest extends \InpsydeUsersTestCase {
	/**
	 * Method to test init.
	 */
	public function test_init() {

		$inpsyde_users_mock = \Mockery::mock( Inpsyde_Users::class )->makePartial();
		$inpsyde_users_mock->shouldReceive( 'init_hooks' );
		$inpsyde_users_mock::init();		
	}

	/**
	 * Method to test init_hooks.
	 */
	public function test_init_hooks() {

		Inpsyde_Users::init_hooks();
		$this->assertTrue( has_action( 'init', [ Inpsyde_Users::class, 'add_users_endpoint' ], 99 ) );
        $this->assertTrue( has_action( 'init', [ Inpsyde_Users::class, 'add_custom_filters' ], 99 ) );
		$this->assertTrue( has_filter( 'request', [ Inpsyde_Users::class, 'users_filter_request' ] ) );
		$this->assertTrue( has_action( 'template_redirect', [ Inpsyde_Users::class, 'show_users_list' ] ) );
		$this->assertTrue( has_action( 'wp_enqueue_scripts', [ Inpsyde_Users::class, 'enqueue_styles_and_scripts' ] ) );

	}

	/**
	 * Method to test add_users_endpoint.
	 */
	public function test_add_users_endpoint() {
		define( 'EP_ROOT', 'test' );

		Functions\expect( 'add_rewrite_endpoint' )
			//->once()
			->with( 'ipusers', EP_ROOT )
			->andReturn( true );
		Inpsyde_Users::add_users_endpoint();
	}

	/**
	 * Method to test add_custom_filters.
	 */
	public function test_add_custom_filters() {
		$api_host_url = "http://google.com";
		Functions\expect( 'apply_filters' )
			//->once()
			->with( 'ip_users_api_host', $api_host_url )
			->andReturn( $api_host_url );

		$cache_time = 86400;
		Functions\expect( 'apply_filters' )
			//->once()
			->with( 'ip_users_cache_time', $cache_time )
			->andReturn( $cache_time );
		Inpsyde_Users::add_custom_filters();
		$this->assertFalse( false, Inpsyde_Users::$cache_user_info );

	}

	/**
	 * Method to test users_filter_request.
	 */
	public function test_users_filter_request() {
		$vars['ipusers'] = '';
		$vars_result = Inpsyde_Users::users_filter_request( $vars );
		$this->assertTrue( true, $vars_result['ipusers'] );

	} 

	/**
	 * Method to test get_users_data.
	 */
	public function test_get_users_data() {

		$expected_response = array( "id" => 1, 
									"name" => "Leanne Graham", 
									"username" => "Bret",  
									"email" => "Sincere@april.biz" );
		Functions\expect( 'get_transient' )
			//->once()
			->with( 'inpsyde_userinfo' )
			->andReturn( false );

		Functions\expect( 'wp_remote_get' )
			//->once()
			->with( 'https://jsonplaceholder.typicode.com/users' )->andReturn( "" );

		Functions\expect( 'wp_remote_retrieve_response_code' )
			//->once()
			->andReturn( 200 );

		Functions\expect( 'wp_remote_retrieve_body' )
			//->once()
			->andReturn( $expected_response );
		Functions\expect( 'set_transient' )
			->with( 'inpsyde_userinfo', $expected_response, 86400 )
			//->once()
			->andReturn( true );
		
		$this->assertEquals( $expected_response, Inpsyde_Users::get_users_data() );
			
	}

}
