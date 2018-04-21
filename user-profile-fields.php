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
            <th><label for="<?php echo Veggie_Challenge::$USER_FIELD_CURRENT_DIET; ?>">Current diet</label></th>

            <?php
            $selected = esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_CURRENT_DIET, $user->ID ) );
            ?>
            <td>
                <select name="<?php echo Veggie_Challenge::$USER_FIELD_CURRENT_DIET; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_CURRENT_DIET; ?>">
                    <option value=""></option>
                    <?php
                    foreach (Veggie_Challenge::$DIET_TYPES as $key => $label):
                        echo '<option value="'.$key.'"';
                        if ($selected == $key ) { echo 'selected="selected"'; }
                        echo '>'.$label.'</option>';
                    endforeach;
                    ?>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_CURRENT_DIET, $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="<?php echo Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE; ?>">Challenge type</label></th>

            <?php
            $selected = esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $user->ID ) );
            ?>
            <td>
                <select name="<?php echo Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE; ?>">
                    <option value=""></option>
                    <?php
                        foreach (Veggie_Challenge::$CHALLENGE_TYPES as $key => $label):
                            echo '<option value="'.$key.'"';
                            if ($selected == $key ) { echo 'selected="selected"'; }
                            echo '>'.$label.'</option>';
                        endforeach;
                    ?>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>">Start date</label></th>

            <td>
                <input type="date" name="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>" value="<?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_START_DATE, $user->ID ) ); ?>" class="date" />
                Saved date: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_START_DATE, $user->ID ) ); ?>
            </td>

        </tr>

    </table>
<?php }

add_action( 'personal_options_update', '_vc_save_challenge_profile_fields' );
add_action( 'edit_user_profile_update', '_vc_save_challenge_profile_fields' );

function _vc_save_challenge_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_CURRENT_DIET, $_POST[Veggie_Challenge::$USER_FIELD_CURRENT_DIET] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $_POST[Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_START_DATE, $_POST[Veggie_Challenge::$USER_FIELD_START_DATE] );
    update_user_meta( $user_id, 'participates_in_veggiechallenge', $_POST['participates_in_veggiechallenge'] );
}