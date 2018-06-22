<?php

/**
 * Fired during plugin activation
 *
 * @link       http://proveg.com
 * @since      1.0.0
 *
 * @package    Veggie_Challenge
 * @subpackage Veggie_Challenge/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Veggie_Challenge
 * @subpackage Veggie_Challenge/includes
 * @author     ProVeg <it@proveg.com>
 */
class Veggie_Challenge_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		add_role( Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE, __('VeggieChallenge subscriber'), array() );
	}

}
