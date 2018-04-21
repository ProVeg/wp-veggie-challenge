<?php
add_filter( 'mailchimp_sync_should_sync_user', function( $subscribe, $user ) {

    $start_date = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_START_DATE, true);
    if (!$start_date){
        return false;
    }

    if (strtotime($start_date) <= time()) {
        return true;
    }

    // do not subscribe otherwise
    return false;
});

add_filter( 'mailchimp_sync_subscriber_data', function( $data, $user ) {

    $challenge_type = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, true);

    foreach(Veggie_Challenge::$CHALLENGE_TYPES as $type_key => $type_label):
        if( $challenge_type == $type_key) {
            $mailchimp_interest_group = get_option('veggie_challenge__mailchimp_interest_'.$type_key.'_id');
            $data->interests[ $mailchimp_interest_group ] = true;
        }
        // else do not set interest group to true, thus remove from interest group
    endforeach;

    return $data;
}, 14, 2 );