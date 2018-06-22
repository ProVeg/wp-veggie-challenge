<?php

/* Add Veggie Challenge fields to user profile page */
add_action( 'show_user_profile', '_vc_show_challenge_profile_fields' );
add_action( 'edit_user_profile', '_vc_show_challenge_profile_fields' );

function _vc_show_challenge_profile_fields( $user ) {

    if ($user->caps[Veggie_Challenge::$VEGGIE_CHALLENGE_SUBSCRIBER_ROLE] != 1) {
        return;
    }
    ?>

    <h3><?php echo __("VeggieChallenge Fields", 'veggie-challenge') ?></h3>

    <table class="form-table">

        <tr>
            <th><label><?php echo __("Participates", 'veggie-challenge') ?></label></th>

            <?php
            $participates = get_the_author_meta( Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE, $user->ID );
            ?>
            <td>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>_yes" type="radio" value="1" <?php echo $participates === "1" ? 'checked="checked"' : '' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>_yes"><?php echo __("Yes", 'veggie-challenge') ?></label>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>_no" type="radio" value="0" <?php echo $participates === "1" ? '' : 'checked="checked"' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE; ?>_no"><?php echo __("No", 'veggie-challenge') ?></label>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE, $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="<?php echo Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE; ?>"><?php echo __("Challenge type", 'veggie-challenge') ?></label></th>

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
                            echo '>'.__($label, 'veggie-challenge').'</option>';
                        endforeach;
                    ?>
                </select>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label for="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>"><?php echo __("Start date", 'veggie-challenge') ?></label></th>

            <td>
                <input type="date" name="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_START_DATE; ?>" value="<?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_START_DATE, $user->ID ) ); ?>" class="date" />
                Saved date: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_START_DATE, $user->ID ) ); ?>
            </td>

        </tr>

        <tr>
            <th><label><?php echo __("Agreed on VeggieChallenge emails", 'veggie-challenge') ?></label></th>

            <?php
            $agreed = get_the_author_meta( Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS, $user->ID );
            ?>
            <td>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>_yes" type="radio" value="1" <?php echo $agreed === "1" ? 'checked="checked"' : '' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>_yes"><?php echo __("Yes", 'veggie-challenge') ?></label>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>_no" type="radio" value="0" <?php echo $agreed === "1" ? '' : 'checked="checked"' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS; ?>_no"><?php echo __("No", 'veggie-challenge') ?></label>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS, $user->ID ) ); ?>
            </td>
        </tr>

        <tr>
            <th><label><?php echo __("Is synced to MailChimp", 'veggie-challenge') ?></label></th>

            <?php
            $participates = get_the_author_meta( Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP, $user->ID );
            ?>
            <td>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>_yes" type="radio" value="1" <?php echo $participates === "1" ? 'checked="checked"' : '' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>_yes"><?php echo __("Yes", 'veggie-challenge') ?></label>
                <input name="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>" id="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>_no" type="radio" value="0" <?php echo $participates === "1" ? '' : 'checked="checked"' ?>>
                <label for="<?php echo Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP; ?>_no"><?php echo __("No", 'veggie-challenge') ?></label>
                Saved key: <?php echo esc_attr( get_the_author_meta( Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP, $user->ID ) ); ?>
            </td>
        </tr>

        <?php
        $form = GFAPI::get_form(intval(get_option('veggie_challenge_gravity_forms_form_id')));

        foreach ($form['fields'] as $field) {

            if ($field['adminLabel'] != '') {
                $user_meta_field_key = 'veggie_challenge_' . $field['adminLabel'];
                ?>
                <tr>
                    <th><label for="<?php echo $user_meta_field_key; ?>"><?php echo $field['label']; ?></label></th>
                    <td>
                        <input type="text" name="<?php echo $user_meta_field_key; ?>" id="<?php echo $user_meta_field_key; ?>" value="<?php echo esc_attr(get_the_author_meta($user_meta_field_key, $user->ID)); ?>" class="text-input"/>
                        User field key: <?php echo $user_meta_field_key; ?>
                    </td>
                </tr>
                <?php
            }
        }

        ?>
    </table>
<?php }

add_action( 'personal_options_update', '_vc_save_challenge_profile_fields' );
add_action( 'edit_user_profile_update', '_vc_save_challenge_profile_fields' );

function _vc_save_challenge_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE, $_POST[Veggie_Challenge::$USER_FIELD_PARTICIPATES_IN_VEGGIE_CHALLENGE] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE, $_POST[Veggie_Challenge::$USER_FIELD_CHALLENGE_TYPE] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_START_DATE, $_POST[Veggie_Challenge::$USER_FIELD_START_DATE] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS, $_POST[Veggie_Challenge::$USER_FIELD_AGREE_VEGGIE_CHALLENGE_EMAILS] );
    update_user_meta( $user_id, Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP, $_POST[Veggie_Challenge::$USER_FIELD_IS_SYNCED_TO_MAILCHIMP] );

    $form = GFAPI::get_form(intval(get_option('veggie_challenge_gravity_forms_form_id')));
    foreach ($form['fields'] as $field) {

        if ($field['adminLabel'] != '') {
            $user_meta_field_key = 'veggie_challenge_' . $field['adminLabel'];
            update_user_meta( $user_id, $user_meta_field_key, $_POST[$user_meta_field_key] );
        }
    }
}