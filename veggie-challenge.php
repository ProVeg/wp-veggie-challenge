<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://proveg.com
 * @since             1.0.0
 * @package           Veggie_Challenge
 *
 * @wordpress-plugin
 * Plugin Name:       VeggieChallenge
 * Plugin URI:        http://proveg.com
 * Description:       This plugin adds a Gravity forms hook to start a MailChimp campaign at a specific date
 * Version:           1.0.0
 * Author:            ProVeg
 * Author URI:        http://proveg.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       veggie-challenge
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-veggie-challenge-activator.php
 */
function activate_veggie_challenge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-veggie-challenge-activator.php';
	Veggie_Challenge_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-veggie-challenge-deactivator.php
 */
function deactivate_veggie_challenge() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-veggie-challenge-deactivator.php';
	Veggie_Challenge_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_veggie_challenge' );
register_deactivation_hook( __FILE__, 'deactivate_veggie_challenge' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-veggie-challenge.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_veggie_challenge() {

	$plugin = new Veggie_Challenge();
	$plugin->run();

}
run_veggie_challenge();

require 'core/hooks-gravity-forms.php';
require 'core/hooks-mailchimp-sync.php';
require 'core/user-profile-fields.php';

?>
