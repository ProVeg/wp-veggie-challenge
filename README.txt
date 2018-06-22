=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: http://proveg.com
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 4.9.0
Stable tag: 4.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a Gravity forms hook to start a MailChimp campaign at a specific date

== Description ==

This plugin adds a Gravity forms hook to start a MailChimp campaign at a specific date

== Installation ==

1. Upload `veggie-challenge` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Set up ==

1. Install the following plugins:
  a. gravityforms (https://www.gravityforms.com/),
  b. mailchimp-for-wp (https://wordpress.org/plugins/mailchimp-for-wp/)
  c. mailchimp-sync (https://wordpress.org/plugins/mailchimp-sync/)

2. Create a gravity form with the following fields
  a. Email text input
  b. Challenge type select list (with values: vegan, vegetarian, meat_free_days)
  c. Start date input
  d. Agreement checkbox

3. Set up your MailChimp account
  a. Create a list that will contain the VeggieChallenge participants
  b. Add an interest group to the list with options Vegan, Vegetarian and Meat Free Days
  c. create an MailChimp API key at Account -> Profile -> Extras -> API Keys

4. Connect Wordpress to Mailchimp
  a. Visit the MailChimp for WP settings page
  b. Ender your MailChimp API key and save changes
  c. Make sure you are connected

5. Set up the VeggieChallenge plugin
  a. Visit the VeggieChallenge settings page (Settings -> VeggieChallenge)
  b. Choose the form that you have created and save changes
  c. Link the correct form fields
  d. Link the correct MailChimp interest groups

6. Sync users
  a. Visit the Synchronization page (MailChimp for WP -> User sync)
  b. Select the list that should be synced
  c. Select 'VeggieChallenge subscriber' as role to sync
  c. Run a manual synchronization or set up a cron job to execute the following WP CLI command: wp mailchimp-sync sync-all

== Extra: Sync extra user meta ==

1. Create a form field in the gravity form and set an 'admin field label' for that field in the 'Advanced' tab.
2. Check the users profile page to see if the extra user meta is visible and take note of the field key.
3. Add a mapping from field key to Mailchimp merge field in the 'MailChimp for WP -> User sync' page.
Note: if you are using dropdowns, make sure the option labels match the option labels in Mailchimp.