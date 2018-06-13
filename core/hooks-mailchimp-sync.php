<?php

function veggie_challenge_mailchimp_sync_should_sync_user( $subscribe, $user ) {

    $is_synced_to_mailchimp = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP, true);
    if ($is_synced_to_mailchimp){
        return true;
    }

    $agree_veggie_challenge_emails = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS, true);
    if (!$agree_veggie_challenge_emails){
        return false;
    }

    $participates = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE, true);
    if (!$participates){
        return false;
    }

    $start_date = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_START_DATE, true);
    if (!$start_date){
        return false;
    }

    if (strtotime($start_date) > time()) {
        return false;
    }
    
    //update_user_meta( $user->ID, Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP, '1');

    return true;
};
add_filter( 'mailchimp_sync_should_sync_user', 'veggie_challenge_mailchimp_sync_should_sync_user', 10, 2 );

add_filter( 'mailchimp_sync_subscriber_data', function( $data, $user ) {

    $challenge_type = get_user_meta($user->ID, Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, true);

    foreach(Veggie_Challenge::$CHALLENGE_TYPES as $type_key => $type_label):
        if( $challenge_type == $type_key) {
            $mailchimp_interest_group = get_option('veggie_challenge_mailchimp_interest_'.$type_key.'_id');
            $data->interests[ $mailchimp_interest_group ] = true;
        }
        // else do not set interest group to true, thus remove from interest group
    endforeach;

    //$data->merge_fields['MMERGE3'] = 'vegan duh';

    // var_dump($data);
    // exit;

    return $data;
}, 14, 2 );