<?php
/**
 * Inpsyde Users plugin file.
 *
 * @package Inspyde_Users
 */

/**
 * Represents all methods for Inpsyde Users functionality.
 */
class Inpsyde_Users {
	/**
	 * Variable to set api host.
	 *
	 * @var $api_host
	 */
	public static $api_host = 'https://jsonplaceholder.typicode.com';

	/**
	 * Variable to set caching time.
	 *
	 * @var $cache_time
	 */
	public static $cache_time = 86400;

	/**
	 * Flag to cache user info.
	 *
	 * @var $cache_user_info
	 */
	public static $cache_user_info = true;

	/**
	 * Variable to initiate the class.
	 *
	 * @var $initiated
	 */
	public static $initiated = false;

	/**
	 * Initial method of the class.
	 */
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks.
	 */
	public static function init_hooks() {
		self::$initiated = true;
		add_action( 'init', array( 'Inpsyde_Users', 'add_users_endpoint' ), 99 );
		add_action( 'init', array( 'Inpsyde_Users', 'add_custom_filters' ), 99 );
		add_filter( 'request', array( 'Inpsyde_Users', 'users_filter_request' ) );
		add_action( 'template_redirect', array( 'Inpsyde_Users', 'show_users_list' ) );
		add_action( 'wp_enqueue_scripts', array( 'Inpsyde_Users', 'enqueue_styles_and_scripts' ) );

	}

	/**
	 * Method to create custom endpoint.
	 */
	public static function add_users_endpoint() {
		add_rewrite_endpoint( 'ipusers', EP_ROOT );
	}

	/**
	 * Method to create custom filters for api_host and cache_time
	 */
	public static function add_custom_filters() {
		$previous_api_host = self::$api_host;
		// Custom api_host using below filter.
		self::$api_host = apply_filters( 'ip_users_api_host', self::$api_host );
		if ( $previous_api_host != self::$api_host ) {
			self::$cache_user_info = false;
		}

		$previous_cache_time = self::$cache_time;
		// Custom cache_time using below filter.
		self::$cache_time = apply_filters( 'ip_users_cache_time', self::$cache_time );
		if ( $previous_cache_time != self::$cache_time ) {
			self::$cache_user_info = false;
		}
	}

	/**
	 * Method to set query variable for custom endpoint to true.
	 *
	 * @param VarsArray $vars The vars array.
	 */
	public static function users_filter_request( $vars ) {
		if ( isset( $vars['ipusers'] ) && empty( $vars['ipusers'] ) ) {
			$vars['ipusers'] = true;
		}
		return $vars;
	}

	/**
	 * Method to show users list.
	 */
	public static function show_users_list() {
		if ( get_query_var( 'ipusers' ) ) {
			$users_data = self::get_users_data();

			if ( ! empty( $users_data ) ) {
				$users_data = json_decode( $users_data, true );
			}
			// Filter to add custom template to display users list.
			$template_path = apply_filters( 'ip_users_list_template', IP_USERS__PLUGIN_DIR . 'templates/list-users.php' );

			include( $template_path );
			exit();
		}
	}

	/**
	 * Method to get users data from api.
	 */
	public static function get_users_data() {

		// Checking if user data is already in cache.
		$inpsyde_userinfo = get_transient( 'inpsyde_userinfo' );
		if ( false === $inpsyde_userinfo || empty( $inpsyde_userinfo ) || ! self::$cache_user_info ) {
			// User data not in cache, so get data from api.
			$host       = self::$api_host;
			$cache_time = self::$cache_time;

			$response   = wp_remote_get( $host . '/users' );
			// Checking if request is successful.
			$http_code = wp_remote_retrieve_response_code( $response );

			if ( 200 == $http_code ) {
				$inpsyde_userinfo = wp_remote_retrieve_body( $response );
				// Caching user data.
				set_transient( 'inpsyde_userinfo', $inpsyde_userinfo, $cache_time );
			} else {
				return false;
			}
		}
		return $inpsyde_userinfo;
	}

	/**
	 * Method to enqueue styles and scripts.
	 */
	public static function enqueue_styles_and_scripts() {
		if ( get_query_var( 'ipusers' ) ) {
			wp_enqueue_style( 'dataTables-css', 'https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css', null, '1.10.20' );
			wp_enqueue_style( 'inpsyde-users-css', esc_url( plugins_url( '../assets/css/inpsyde-users.min.css', __FILE__ ) ), null, '1.0' );
			wp_enqueue_script( 'ip-jquery', 'https://code.jquery.com/jquery-3.3.1.js', null, '3.3.1' );
			wp_enqueue_script( 'dataTables-js', 'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js', null, '1.10.20' );
			wp_enqueue_script( 'inpsyde-users-js', esc_url( plugins_url( '../assets/js/inpsyde-users.min.js', __FILE__ ) ), null, '1.0', true );
		}
	}

}
