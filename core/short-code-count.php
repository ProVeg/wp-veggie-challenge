<?php

add_shortcode( 'get_veggie_challenge_count', function() {
    return intval(get_option('veggie_challenge_general_count'));
});

?>