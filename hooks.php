<?php

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

add_action( 'gform_after_submission', 'set_post_content', 10, 2 );
function set_post_content( $entry, $form ) {
    $veggie_challenge_form_id = intval(get_option('veggie_challenge_gravity_forms_form_id'));

    // check if this is the right form
    if ($form['id'] !== $veggie_challenge_form_id){
        return;
    }

    // check if the user exists
    $user_id = username_exists($user_name);

    // if the user does not exist, create it
    if (!$user_id and email_exists($user_email) == false ) {
        $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
        $user_id = wp_create_user( $user_name, $random_password, $user_email );
    }
}