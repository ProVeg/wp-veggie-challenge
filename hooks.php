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
    $form_error = new WP_Error();

    $veggie_challenge_form_id = intval(get_option('veggie_challenge_gravity_forms_form_id'));
    $veggie_challenge_role_id = get_role('veggiechallenge');
    $email_address_field_id = intval(get_option('veggie_challenge_gravity_forms_form_email_field'));
    $challenge_field_id = intval(get_option('veggie_challenge_gravity_forms_form_challenge_field'));
    $agree_veggie_challenge_emails_field_id = intval(get_option('veggie_challenge_gravity_forms_form_agree_veggie_challenge_emails_field'));
    $start_date_field_id = intval(get_option('veggie_challenge_gravity_forms_form_start_date_field'));

    // check if this is the right form
    if ($form['id'] !== $veggie_challenge_form_id){
        return;
    }
    
    $email_address = $entry[$email_address_field_id];
    $challenge = $entry[$challenge_field_id];
    $agree = $entry[$agree_veggie_challenge_emails_field_id];
    $start_date = $entry[$veggie_challenge_gravity_forms_form_start_date_field];

    $agree_veggie_challenge_emails = $entry["$agree_veggie_challenge_emails_field_id.1"];
    if (!$agree_veggie_challenge_emails || $agree_veggie_challenge_emailsagree === __("No") || $agree_veggie_challenge_emails === __("no")) {
        $form_error->add( 'agree', __("Agree should not be empty and not equal to 'no'"));
    }

    if ( is_wp_error( $form_error ) ) {
        foreach ( $form_error->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>' . __("ERROR") . ':</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }

    if ($form_error->get_error_messages() === 0) {

        // check if the user exists
        $user_id = username_exists( $email_address );
    
        // if the user does not exist, create it
        if (!$user_id && email_exists( $email_address ) == false ) {
            $random_password = wp_generate_password( $length=16, $include_standard_special_chars=false );
            $user_id = wp_create_user( $email_address, $random_password, $email_address );
            wp_update_user( array( 'ID' => $user_id, 'role' => 'veggiechallenge' ) );
        }
    
        update_user_meta( $user_id, 'participates_in_veggiechallenge', '1');
        update_user_meta( $user_id, 'challenge', $challenge);
        update_user_meta( $user_id, 'start_date', $start_date);
        update_user_meta( $user_id, 'agree_veggie_challenge_emails', $agree_veggie_challenge_emails);
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