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

    $please_configure = ". Please configure on the VeggieChallenge settings page.";

    $veggie_challenge_form_id = intval(get_option('veggie_challenge_gravity_forms_form_id'));

    // check if this is the right form
    if ($form['id'] !== $veggie_challenge_form_id){
        return;
    }

    $email_address_field_id = intval(get_option('veggie_challenge_gravity_forms_form_email_field'));
    if (!($email_address_field_id > 0)) {
        $form_error->add( 'email_address_field_id', __("Email Address Field Id not set".$please_configure, "veggie_challenge"));
    }

    $challenge_field_id = intval(get_option('veggie_challenge_gravity_forms_form_challenge_field'));
    if (!($challenge_field_id > 0)) {
        $form_error->add( 'challenge_field_id', __("Challenge Field Id not set".$please_configure, "veggie_challenge"));
    }

    $agree_veggie_challenge_emails_field_id = intval(get_option('veggie_challenge_gravity_forms_form_agree_veggie_challenge_emails_field'));
    if (!($agree_veggie_challenge_emails_field_id > 0)) {
        $form_error->add( 'agree_veggie_challenge_emails_field_id', __("Agree Veggie Challenge Emails Field Id not set.$please_configure", "veggie_challenge"));
    }

    $start_date_field_id = intval(get_option('veggie_challenge_gravity_forms_form_start_date_field'));
    if (!($start_date_field_id > 0)) {
        $form_error->add( 'start_date_field_id', __("Start Date Field Id not set.$please_configure", "veggie_challenge"));
    }

    $veggie_challenge_role_id = get_role(Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE);
    if (!($veggie_challenge_role_id > 0)) {
        $form_error->add( 'veggie_challenge_role_id', __("VeggieChallenge User role does not exist. Please reinstall the plugin.", "veggie_challenge"));
    }
    
    $email_address = $entry[$email_address_field_id];
    if (!$email_address) {
        $form_error->add( 'email_address', __("Email address is required", "veggie_challenge"));
    }
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $form_error->add( 'email_address', __("The supplied email address is not valid", "veggie_challenge"));
    }

    $challenge = $entry[$challenge_field_id];
    if (!$challenge) {
        $form_error->add( 'challenge', __("Desired challenge is required", "veggie_challenge"));
    }
    if (!in_array($challenge, array_keys(Veggie_Challenge::$CHALLENGE_TYPES))) {
        $form_error->add( 'challenge', __("The supplied challenge is not a valid challenge. Valid challenges are: ", "veggie_challenge") . implode(", ", array_keys(Veggie_Challenge::$CHALLENGE_TYPES)));
    }

    $start_date = $entry[$start_date_field_id];
    if (!$challenge) {
        $form_error->add( 'start_date', __("Start date is required", "veggie_challenge"));
    }
    if (strtotime($start_date) === false) {
        $form_error->add( 'start_date', __("The supplied start date is not a valid date", "veggie_challenge"));
    }

    $agree_veggie_challenge_emails = $entry["$agree_veggie_challenge_emails_field_id.1"];
    if (!$agree_veggie_challenge_emails) {
        $form_error->add( 'agree', __("It is required to agree to receiving VeggieChallenge emails", "veggie_challenge"));
    }

    if ( is_wp_error( $form_error ) ) {
        foreach ( $form_error->get_error_messages() as $error ) {
            echo '<div>';
            echo '<strong>' . __("ERROR", "veggie_challenge") . ':</strong>:';
            echo $error . '<br/>';
            echo '</div>';
        }
    }

    if (count($form_error->get_error_messages()) === 0) {

        // check if the email address exists
        $user_id = email_exists( $email_address );

        // if the user does not exist, create it
        if (!$user_id) {
            $random_password = wp_generate_password( $length=16, $include_standard_special_chars=false );
            $username = "vc_" . substr(time(), 0, 5) . "_" . $email_address;
            $user_id = wp_create_user( $username, $random_password, $email_address );
            wp_update_user( array( 'ID' => $user_id, 'role' => Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE ) );
        } else {

            // else add role to existing user
            $user = new WP_User($user_id);

            $user_meta=get_userdata($user_id);
            $user_roles=$user_meta->roles;
            if(!in_array(Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE, $user_roles)) {
                // Add role as first role for Mailchimp for WP plugin to see it.
                $user->set_role(Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE);
                foreach($user_roles as $role) {
                    $user->add_role($role);
                }
            }
        }

        // store required veggie challenge fields
        update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE, '1');
        update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $challenge);
        update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_START_DATE, $start_date);
        update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS, '1');



        // save extra custom user meta fields
        foreach ($form['fields'] as $field) {
            if ($field['adminLabel'] != '') {
                $user_meta_field_key = 'veggie_challenge_' . $field['adminLabel'];

                if($field['type'] == 'checkbox') {
                    $value = $field->get_value_export( $entry, $field->id, true );
                } else {
                    $value = $entry[$field['id']];
                }

                update_user_meta( $user_id, $user_meta_field_key, $value);
            }
        }

    }
}
add_action( 'gform_after_submission', 'set_post_content', 10, 2 );