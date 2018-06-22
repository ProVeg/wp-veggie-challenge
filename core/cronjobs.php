<?php

add_action( 'veggie_challenge_sync_users_event',  'veggie_challenge_sync_users' );

function veggie_challenge_sync_users() {

    $options = $GLOBALS['mailchimp_sync']->options;

    $list_id = $options['list'];
    $users = new MC4WP\Sync\Users( $list_id, $options['role'] );
    $user_handler = new MC4WP\Sync\UserHandler( $list_id, $users, $options );

    // start by counting all users
    $users = $users->get( array('role' => Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE) );
    $count = count( $users );
    $user_ids = wp_list_pluck( $users, 'ID' );

    echo( "$count users found." );

    if( $count <= 0 ) {
        return;
    }

    foreach( $user_ids as $user_id ) {
        $user_handler->subscribe_user( $user_id );
    }

    echo( sprintf( "Synchronized %d users.", $count ) );
}