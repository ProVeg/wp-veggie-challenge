<?php

/* Add Veggie Challenge fields to user profile page */
add_action( 'show_user_profile', '_vc_show_challenge_profile_fields' );
add_action( 'edit_user_profile', '_vc_show_challenge_profile_fields' );

function _vc_show_challenge_profile_fields( $user ) { ?>

    <h3><?php echo __("VeggieChallenge Fields") ?></h3>

    <table class="form-table">

        <tr>
            <th><label><?php echo __("Participates") ?></label></th>

            <?php
            $participates = get_the_author_meta( 'participates_in_veggiechallenge', $user->ID );
            ?>
            <td>
                <input name="participates_in_veggiechallenge" id="participates_in_veggiechallenge_yes" type="radio" value="1" <?php echo $participates === "1" ? 'checked="checked"' : '' ?>>
                <label for="participates_in_veggiechallenge_yes"><?php echo __("Yes") ?></label>
                <input name="participates_in_veggiechallenge" id="participates_in_veggiechallenge_no" type="radio" value="0" <?php echo $participates === "1" ? '' : 'checked="checked"' ?>>
                <label for="participates_in_veggiechallenge_no"><?php echo __("No") ?></label>
                Saved key: <?php echo esc_attr( get_the_author_meta( 'participates_in_veggiechallenge', $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="current_diet">Current diet</label></th>

            <?php
            $selected = esc_attr( get_the_author_meta( 'current_diet', $user->ID ) );
            ?>
            <td>
                <select name="current_diet" id="current_diet">
                    <option value=""></option>
                    <option value="vegan" <?php if ($selected == 'vegan' ) { echo 'selected'; } ?>>Vegan</option>
                    <option value="flexanist" <?php if ($selected == 'flexanist' ) { echo 'selected'; } ?>>Flexanist</option>
                    <option value="vegetarian" <?php if ($selected == 'vegetarian' ) { echo 'selected'; } ?>>Vegetarian</option>
                    <option value="flexitarian" <?php if ($selected == 'flexitarian' ) { echo 'selected'; } ?>>Flexitarian</option>
                    <option value="omnivore" <?php if ($selected == 'omnivore' ) { echo 'selected'; } ?>>Omnivore</option>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( 'current_diet', $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="challenge_type">Challenge type</label></th>

            <?php
            $selected = esc_attr( get_the_author_meta( 'challenge_type', $user->ID ) );
            ?>
            <td>
                <select name="challenge_type" id="challenge_type">
                    <option value=""></option>
                    <option value="vegan" <?php if ($selected == 'vegan' ) { echo 'selected'; } ?>>Vegan</option>
                    <option value="vegetarian" <?php if ($selected == 'vegetarian' ) { echo 'selected'; } ?>>Vegetarian</option>
                    <option value="meatfreedays" <?php if ($selected == 'meatfreedays' ) { echo 'selected'; } ?>>Meat Free Days</option>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( 'challenge_type', $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="start_date">Start date</label></th>

            <td>
                <input type="date" name="start_date" id="start_date" value="<?php echo esc_attr( get_the_author_meta( 'start_date', $user->ID ) ); ?>" class="date" />
                Saved date: <?php echo esc_attr( get_the_author_meta( 'start_date', $user->ID ) ); ?>
            </td>

        </tr>

    </table>
<?php }

add_action( 'personal_options_update', '_vc_save_challenge_profile_fields' );
add_action( 'edit_user_profile_update', '_vc_save_challenge_profile_fields' );

function _vc_save_challenge_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'current_diet', $_POST['current_diet'] );
    update_user_meta( $user_id, 'challenge_type', $_POST['challenge_type'] );
    update_user_meta( $user_id, 'start_date', $_POST['start_date'] );
    update_user_meta( $user_id, 'participates_in_veggiechallenge', $_POST['participates_in_veggiechallenge'] );
}