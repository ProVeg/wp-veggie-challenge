<?php

/**
  * Function to create a user when the veggiechallenge signup form is submitted
  *
  * @author Ad van Wingerden <ad.van.wingerden@proveg.com>
  *
  * @param array  $entry    The submitted form data
  * @param array  $form     Contains information about the form
 */
function set_post_content( $entry, $form ) {
    $veggie_challenge_form_id = intval(get_option('veggie_challenge_gravity_forms_form_id'));
    $veggie_challenge_role_id = get_role('VeggieChallenge Subcriber');

    // check if this is the right form
    if ($form['id'] !== $veggie_challenge_form_id){
        return;
    }
    
    $email_address_field_id = 2;
    $email_address = $entry[$email_address_field_id];

    // check if the user exists
    $user_id = username_exists( $email_address );

    // if the user does not exist, create it
    if (!$user_id and email_exists( $email_address ) == false ) {
        $random_password = wp_generate_password( $length=16, $include_standard_special_chars=false );
        $user_id = wp_create_user( $email_address, $random_password, $email_address );
        wp_update_user( array( 'role' => $veggie_challenge_role_id ) );
    }


}
add_action( 'gform_after_submission', 'set_post_content', 10, 2 );

add_filter( 'mailchimp_sync_should_sync_user', function( $subscribe, $user ) {

    $start_date = get_user_meta($user->ID, 'start_date', true);
    if (!$start_date){
        return false;
    }

    if (strtotime($start_date) <= time()) {
        return true;
    }

    // do not subscribe otherwise
    return false;
});