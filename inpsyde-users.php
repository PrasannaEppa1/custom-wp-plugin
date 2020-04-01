<?php
/**
 * Plugin Name
 *
 * @package           InpsydeUsers
 * @author            PrasannaEppa
 * @copyright         2019 PrasannaEppa
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Inpsyde Users
 * Plugin URI:        https://example.com/plugin-name
 * Description:       A plugin to show list of users getting data from Inpsyde REST Api.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            PrasannaEppa
 * Author URI:        https://example.com
 * Text Domain:       inpsyde-users
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/*
Inpsyde Users is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Inpsyde Users is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Inpsyde Users. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

// Make sure we don't expose any info if called directly.
if ( ! function_exists( 'add_action' ) ) {
	echo 'Invalid request';
	exit;
}

define( 'IP_USERS_VERSION', '1.0' );
define( 'IP_USERS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

register_activation_hook( __FILE__, 'ip_users_plugin_activation' );
register_deactivation_hook( __FILE__, 'ip_users_plugin_deactivation' );

if ( ! function_exists( 'ip_users_plugin_activation' ) ) {
	/**
	 * Extending  register_activation_hook.
	 */
	function ip_users_plugin_activation() {
		// clear the permalinks to remove custom url from the database.
		flush_rewrite_rules();
	}
}
if ( ! function_exists( 'ip_users_plugin_deactivation' ) ) {
	/**
	 * Extending  register_deactivation_hook.
	 */
	function ip_users_plugin_deactivation() {
		// clear the permalinks to remove custom url from the database.
		flush_rewrite_rules();
	}
}

require_once( IP_USERS__PLUGIN_DIR . 'classes/class-inpsyde-users.php' );
add_action( 'init', array( 'Inpsyde_Users', 'init' ) );


