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
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
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

// TODO: Move to separate file
/* Add Veggie Challenge fields to user profile page */

add_action( 'show_user_profile', '_vc_show_challenge_profile_fields' );
add_action( 'edit_user_profile', '_vc_show_challenge_profile_fields' );

function _vc_show_challenge_profile_fields( $user ) { ?>

    <h3>Veggie Challenge Fields</h3>

    <table class="form-table">

        <tr>
            <th><label for="current_diet">Current diet</label></th>

            <?php
                $selected = esc_attr( get_the_author_meta( 'current_diet', $user->ID ) );
            ?>
            <td>
                <select name="current_diet" id="current_diet">
                    <option value=""></option>
                    <option value="vegan" <?php if ($selected == 'vegan' ) { echo 'selected'; } ?>>Vegan</option>
                    <option value="flexanist" <?php if ($selected == 'flexanist' ) { echo 'selected'; } ?>>Flexanist</option>
                    <option value="vegetarian" <?php if ($selected == 'vegetarian' ) { echo 'selected'; } ?>>Vegetarian</option>
                    <option value="flexitarian" <?php if ($selected == 'flexitarian' ) { echo 'selected'; } ?>>Flexitarian</option>
                    <option value="omnivore" <?php if ($selected == 'omnivore' ) { echo 'selected'; } ?>>Omnivore</option>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( 'current_diet', $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="challenge_type">Challenge type</label></th>

            <?php
                $selected = esc_attr( get_the_author_meta( 'challenge_type', $user->ID ) );
            ?>
            <td>
                <select name="challenge_type" id="challenge_type">
                    <option value=""></option>
                    <option value="vegan" <?php if ($selected == 'vegan' ) { echo 'selected'; } ?>>Vegan</option>
                    <option value="vegetarian" <?php if ($selected == 'vegetarian' ) { echo 'selected'; } ?>>Vegetarian</option>
                    <option value="meatfreedays" <?php if ($selected == 'meatfreedays' ) { echo 'selected'; } ?>>Meat Free Days</option>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( 'challenge_type', $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="start_date">Start date</label></th>

            <td>
                <input type="date" name="start_date" id="start_date" value="<?php echo esc_attr( get_the_author_meta( 'start_date', $user->ID ) ); ?>" class="date" />
                Saved date: <?php echo esc_attr( get_the_author_meta( 'start_date', $user->ID ) ); ?>
            </td>

        </tr>

    </table>
<?php }

add_action( 'personal_options_update', '_vc_save_challenge_profile_fields' );
add_action( 'edit_user_profile_update', '_vc_save_challenge_profile_fields' );

function _vc_save_challenge_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'current_diet', $_POST['current_diet'] );
    update_user_meta( $user_id, 'challenge_type', $_POST['challenge_type'] );
    update_user_meta( $user_id, 'start_date', $_POST['start_date'] );
}

?>
