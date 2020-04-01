<?php
// define test environment
define( 'INPSYDEUSERS_PHPUNIT', true );

// define fake ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() );
}
// define fake INPSYDEUSERS_ABSPATH
if ( ! defined( 'INPSYDEUSERS_ABSPATH' ) ) {
	define( 'INPSYDEUSERS_ABSPATH', __FILE__ );
}
require_once __DIR__ . '/../../vendor/autoload.php';


require_once( __DIR__ . '/../../classes/class-inpsyde-users.php' );

// Include the class for InpsydeUsersTestCase
require_once __DIR__ . '/InpsydeUsersTestCase.php';
