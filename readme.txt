=== Inpsyde Users ===
Contributors: prasannaeppa
Tags: inspyde-users
Requires at least: 5.3
Tested up to: 5.3
Stable tag: 1.0
License: GPLv2 or later

Inpsyde Users gets users data from third party server and shows list in a table.

== Description ==

Inpsyde Users gets users data from third party server and shows list in a table. When clicked on any user shows single user details.

Major features in Inpsyde Users include:

* Gets users data from third party server https://jsonplaceholder.typicode.com/.
* Shows users list in a table. 
* Shows single user details when clicked on any user.

== Installation ==

### INSTALL INPSYDE USERS THROUGH COMPOSER

1. Clone inpsyde users plugin from git repository https://prasannaeppa@bitbucket.org/prasannaeppa/inpsyde-users.git to your local system.
1. Now in the root folder of your Wordpress instance, make sure you have composer.json file (in not present, create it).
1. In composer file, add this plugin "prasannaeppa/inpsyde-users" to require json object.
1. Also add repositories array specifying the path to the plugin (in your local system) which lets Wordpress know from where the plugin need to be installed.
1. After that, do a composer update from your Wordpress root directory.
1. Thats it, plugin will be installed to your Wordpress instance.
1. Activate the plugin through the 'Plugins' menu in Wordpress.

== Usage Instructions ==

1. Go to the custom url "{yourdomain}/ipusers".
1. This displays list of users in a table with user details such as id, name, username, email, phone.
1. This users list has pagination, sorting and search options.
1. Clicking on any user in the table, shows the details of the single user.
1. When clicked on any of the fields of the list like id, name, username makes the page scroll down taking us to the single user detail section without reloading the page.

== Implementation details ==

1. Added a new custom endpoint called "ipusers" on initialization of the plugin.
1. This custom endpoint when accessed, calls third party api and gets the user data.
1. User data which is retrieved is cached for one day so that custom endpoint will not hit the third party api everytime to get the data.
1. After the response is received, a template is loaded to display users list.
1. On clicking on any user triggers an ajax call( through jQuery) again to thrid party api and displays single user details.
1. Used jQuery ajax to get single user data in order to prevent multiple http requests.
1. Added WP custom filters to customize few settings in the plugin like api url, caching time and template which shows users.