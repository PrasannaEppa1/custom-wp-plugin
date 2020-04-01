<?php
/**
 * Auth header
 *
 * This template is used to show users list
 *
 * @package Inpsyde_Users
 */

// phpcs:disable VariableAnalysis
// There are "undefined" variables here because they're defined in the code that includes this file as a template.

?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
?>
<div class = "container">
	<h2 class = "user-list-heading">Users List</h2>
	<table id="users-list" class="display cell-border">
		<thead>
			<tr>
				<th><?php esc_html_e( 'ID', 'inspyde-users' ); ?></th>
				<th><?php esc_html_e( 'Name', 'inspyde-users' ); ?></th>
				<th><?php esc_html_e( 'Username', 'inspyde-users' ); ?></th>
				<th><?php esc_html_e( 'Email', 'inspyde-users' ); ?></th>
				<th><?php esc_html_e( 'Phone', 'inspyde-users' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( ! empty( $users_data ) ) : ?>
				<?php foreach ( $users_data as $user ) : ?>
					<tr>
						<td><a class = "user" href = "javascript:void(0)" data-user-id = "<?php echo $user['id']; ?>"><?php echo $user['id']; ?></a></td>
						<td><a class = "user" href = "javascript:void(0)" data-user-id = "<?php echo $user['id']; ?>"><?php echo $user['name']; ?></a></td>
						<td><a class = "user" href = "javascript:void(0)" data-user-id = "<?php echo $user['id']; ?>"><?php echo $user['username']; ?></a></td>
						<td><?php echo $user['email']; ?></td>
						<td><?php echo $user['phone']; ?></td>
					</tr>
				<?php endforeach; ?>  
			<?php endif; ?>
			</tbody>
		<tfoot>
			<tr>
			<th><?php esc_html_e( 'ID', 'inspyde-users' ); ?></th>
			<th><?php esc_html_e( 'Name', 'inspyde-users' ); ?></th>
			<th><?php esc_html_e( 'Username', 'inspyde-users' ); ?></th>
			<th><?php esc_html_e( 'Email', 'inspyde-users' ); ?></th>
			<th><?php esc_html_e( 'Phone', 'inspyde-users' ); ?></th>
		</tfoot>
	</table>

	<div id = "user-detail">
	<img class = "loader" src = "<?php echo esc_url( plugins_url( '../assets/img/loader.gif', __FILE__ ) ); ?>">
	</div>
</div>


<?php get_footer(); ?>
