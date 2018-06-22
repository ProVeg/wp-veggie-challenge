<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://proveg.com
 * @since      1.0.0
 *
 * @package    Veggie_Challenge
 * @subpackage Veggie_Challenge/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Veggie_Challenge
 * @subpackage Veggie_Challenge/admin
 * @author     ProVeg <it@proveg.com>
 */
class Veggie_Challenge_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * The options name to be used in this plugin
     *
     * @since    1.0.0
     * @access    private
     * @var    string $option_name Option name of this plugin
     */
    private $option_name = 'veggie_challenge';

    /**
     * The retrieved mailchimp interests
     *
     * @since    1.0.0
     * @access    private
     * @var    string $mailchimp_interests
     */
    private $mailchimp_interests = Array();

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Veggie_Challenge_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Veggie_Challenge_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/veggie-challenge-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Veggie_Challenge_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Veggie_Challenge_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/veggie-challenge-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since  1.0.0
     */
    public function add_options_page()
    {

        $this->plugin_screen_hook_suffix = add_options_page(
            __('VeggieChallenge Settings', 'veggie-challenge'),
            __('VeggieChallenge', 'veggie-challenge'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_options_page')
        );

    }

    /**
     * Render the options page for plugin
     *
     * @since  1.0.0
     */
    public function display_options_page()
    {
        include_once 'partials/veggie-challenge-admin-display.php';
    }


    /**
     * Register all related settings of this plugin
     *
     * @since  1.0.0
     */
    public function register_setting()
    {
        $this->register_general_settings();

        if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
            $this->register_gravity_forms_settings();
        } else {
            add_settings_section(
                $this->option_name . '_vc_gravity_forms',
                __('Gravity Forms', 'veggie-challenge'),
                array($this, $this->option_name . '_gravity_forms_not_activated_render'),
                $this->plugin_name
            );
        }

        if ( is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) && is_plugin_active( 'mailchimp-sync/mailchimp-sync.php' ) ) {
            $this->register_mailchimp_settings();
        } else {
            add_settings_section(
                $this->option_name . '_vc_mailchimp',
                __('Mailchimp', 'veggie-challenge'),
                array($this, $this->option_name . '_mailchimp_not_activated_render'),
                $this->plugin_name
            );
        }

    }

    private function register_general_settings()
    {
        add_settings_section(
            $this->option_name . '_vc_general',
            __('General', 'veggie-challenge'),
            array($this, $this->option_name . '_general_render'),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_general_count',
            __('Number of users that have started the challenge', 'veggie-challenge'),
            array($this, $this->option_name . '_general_count_render'),
            $this->plugin_name,
            $this->option_name . '_vc_general',
            array('label_for' => $this->option_name . '_general_count')
        );
        register_setting($this->plugin_name, $this->option_name . '_general_count');
    }

    private function register_gravity_forms_settings()
    {
        add_settings_section(
            $this->option_name . '_vc_gravity_forms',
            __('Gravity Forms', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_render'),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_gravity_forms_form_id',
            __('Gravity Form', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_id_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_id')
        );
        register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_id');

        add_settings_field(
            $this->option_name . '_gravity_forms_form_email_field',
            __('Email field', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_email_field_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_email_field')
        );
        register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_email_field');

        add_settings_field(
            $this->option_name . '_gravity_forms_form_challenge_field',
            __('Challenge type field', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_challenge_field_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_challenge_field')
        );
        register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_challenge_field');

        add_settings_field(
            $this->option_name . '_gravity_forms_form_start_date_field',
            __('Start date field', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_start_date_field_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_start_date_field')
        );
        register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_start_date_field');

        add_settings_field(
            $this->option_name . '_gravity_forms_form_agree_veggie_challenge_emails_field',
            __('Agree Veggie Challenge Emails field', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_agree_veggie_challenge_emails_field_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_agree_veggie_challenge_emails_field')
        );
        register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_agree_veggie_challenge_emails_field');

        // add_settings_field(
        //     $this->option_name . '_gravity_forms_form_optional_fields_field_render',
        //     __('Optional fields', 'veggie-challenge'),
        //     array($this, $this->option_name . '_gravity_forms_form_optional_fields_field_render'),
        //     $this->plugin_name,
        //     $this->option_name . '_vc_gravity_forms',
        //     array('label_for' => $this->option_name . '_gravity_forms_form_optional_fields_field_render')
        // );
        // register_setting($this->plugin_name, $this->option_name . '_gravity_forms_form_optional_fields_field_render');
    }

    private function register_mailchimp_settings()
    {
        add_settings_section(
            $this->option_name . '_vc_mailchimp',
            __('Mailchimp', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_render'),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_mailchimp_list_id',
            __('Mailchimp List', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_list_setting_render'),
            $this->plugin_name,
            $this->option_name . '_vc_mailchimp',
            array('label_for' => $this->option_name . '_mailchimp_list_id')
        );
        register_setting($this->plugin_name, $this->option_name . '_mailchimp_list_id');

        foreach (Veggie_Challenge::$CHALLENGE_TYPES as $type_key => $type_label):
            add_settings_field(
                $this->option_name . '_mailchimp_interest_'.$type_key.'_id',
                __($type_label.' interest group', 'veggie-challenge'),
                function() use ($type_key) { $this->veggie_challenge_mailchimp_interest_id_render($type_key); },
                $this->plugin_name,
                $this->option_name . '_vc_mailchimp',
                array('label_for' => $this->option_name . '_mailchimp_interest_'.$type_key.'_id')
            );
            register_setting($this->plugin_name, $this->option_name . '_mailchimp_interest_'.$type_key.'_id');
        endforeach;
    }

    /**
     * Render the text for the general section
     *
     * @since  1.0.0
     */
    public function veggie_challenge_general_render()
    {
        echo '<p>' . __('Set the general Veggie Challenge settings.', 'veggie-challenge') . '</p>';
    }


    /**
     * _Render the base count setting input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_general_count_render()
    {
        $base_count = get_option( $this->option_name . '_general_count' );
        echo '<input type="number" name="' . $this->option_name . '_general_count' . '" id="' . $this->option_name . '_general_count' . '" value="'. $base_count .'"/>';
    }

    /**
     * Render the text for the gravity forms section
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_render()
    {
        echo '<p>' . __('Set the Gravity Forms form of the Veggie Challenge.', 'veggie-challenge') . '</p>';
    }

    /**
     * Render the text for the gravity forms section if the plugin is not activated
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_not_activated_render()
    {
        echo '<p>' . __('Gravity forms is not installed and/or activated on this website. Visit the plugin page and install Gravity Forms to continue.', 'veggie-challenge') . '</p>';
    }

    /**
     * _Render the form id settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_id_render()
    {
        $form_id = get_option( $this->option_name . '_gravity_forms_form_id' );

        $select = '<select name="' . $this->option_name . '_gravity_forms_form_id' . '" id="' . $this->option_name . '_gravity_forms_form_id' . '">';
        $forms = RGFormsModel::get_forms( null, 'title' );
        $select .= '<option value="" id="0">'.__('Choose form', 'veggie-challenge'). '</option>';
        foreach( $forms as $form ):
            $select .= '<option value="'. $form->id . '" id="' . $form->id . '"';
            if($form_id == $form->id) $select .= ' selected="selected"';
            $select .= '>' . $form->title . '</option>';
        endforeach;
        $select .= '</select>';

        echo $select;

        if ($form_id != '') echo ' current form id: ' . $form_id;
    }

    /**
     * _Render the form email field settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_email_field_render()
    {
        echo self::buildFormFieldSelectHtml('_gravity_forms_form_email_field');
    }

    /**
     * _Render the form challenge field settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_challenge_field_render()
    {
        echo self::buildFormFieldSelectHtml('_gravity_forms_form_challenge_field');
    }

    /**
     * _Render the form challenge field settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_start_date_field_render()
    {
        echo self::buildFormFieldSelectHtml('_gravity_forms_form_start_date_field');
    }

    /**
     * _Render the form challenge field settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_agree_veggie_challenge_emails_field_render()
    {
        echo self::buildFormFieldSelectHtml('_gravity_forms_form_agree_veggie_challenge_emails_field');
    }

    /**
     * _Render the form challenge field settings input field
     *
     * @since  1.0.0
     */
    // public function veggie_challenge_gravity_forms_form_optional_fields_field_render()
    // {
    //     $current_form_field_id = get_option( $this->option_name . '' . $option_name . '');
    //     echo '<textarea name="' . $this->option_name . '_gravity_forms_form_optional_fields_field"></textarea>';
    // }

    private function buildFormFieldSelectHtml($option_name) {
        $current_form_id = get_option( $this->option_name . '_gravity_forms_form_id' );
        if ($current_form_id == '') {
            return __('Select a form above and save changes to select form fields', 'veggie-challenge');;
        }

        $current_form_field_id = get_option( $this->option_name . '' . $option_name . '');
        $form_meta = RGFormsModel::get_form_meta( $current_form_id );

        $select = '<select name="' . $this->option_name . $option_name . '" id="' . $this->option_name . $option_name . '" >';
        $select .= '<option value="" id="0">'.__('Choose field', 'veggie-challenge'). '</option>';
        foreach( $form_meta['fields'] as $field ):
            if ($field->type != '') {
                $select .= '<option value="'. $field->id . '" id="' . $field->id . '"';
                if($current_form_field_id == $field->id) $select .= ' selected="selected"';
                $select .= '>' . $field->label . '</option>';
            }
        endforeach;
        $select .= '</select>';

        if ($current_form_field_id != '') $select .= ' current id: ' . $current_form_field_id;

        return $select;
    }

    /**
     * Render the text for the Mailchimp section
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_render()
    {
        echo '<p>' . __('Set the interest groups of Mailchimp that are linked to the veggie challenge campaign.', 'veggie-challenge') . '</p>';
    }


    /**
     * Render the text for the mailchimp section if the plugin is not activated
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_not_activated_render()
    {
        echo '<p>' . __('The plugin \'Mailchimp for Wordpress\' along with add-on \'MailChimp User Sync\' are not installed and/or activated on this website. Visit the plugin page and install \'Mailchimp for Wordpress\' and \'MailChimp User Sync\' to continue.', 'veggie-challenge') . '</p>';
    }

    /**
     * _Render the mailchimp list settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_list_setting_render()
    {
        $list_id = get_option( $this->option_name . '_mailchimp_list_id' );

        $select = '<select name="' . $this->option_name . '_mailchimp_list_id' . '" id="' . $this->option_name . '_mailchimp_list_id' . '">';
        $lists = mc4wp('api')->get_lists(array('fields' => 'lists.id,lists.name'));

        $select .= '<option value="" id="0">'.__('Choose list', 'veggie-challenge'). '</option>';
        foreach( $lists as $list ):
            $select .= '<option value="'. $list->id . '" id="' . $list->id . '"';
            if($list_id == $list->id) $select .= ' selected="selected"';
            $select .= '>' . $list->name . '</option>';
        endforeach;
        $select .= '</select>';

        echo $select;

        if ($list_id != '') echo ' current list id: ' . $list_id;
    }

    /**
     * Render the mailchimp interest group settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_interest_id_render($interest_id)
    {
        $current_list_id = get_option( $this->option_name . '_mailchimp_list_id' );
        if ($current_list_id == '') {
            echo __('Select a list above and save changes to select interest groups', 'veggie-challenge');
            return;
        }

        $current_interest = get_option( $this->option_name . '_mailchimp_interest_'.$interest_id.'_id' );

        $interests = self::buildMailchimpInterestsArray($current_list_id);
        if($interests != null) {
            $output = '<select name="' . $this->option_name . '_mailchimp_interest_'.$interest_id.'_id' . '" id="' . $this->option_name . '_mailchimp_interest_'.$interest_id.'_id' . '" >';
            $output .= '<option value="" id="0">'.__('Choose interest group', 'veggie-challenge'). '</option>';
            foreach ($interests as $interest_id => $interest_label):
                if ($interest_id != '') {
                    $output .= '<option value="'. $interest_id . '" id="' . $interest_id . '"';
                    if($current_interest == $interest_id) $output .= ' selected="selected"';
                    $output .= '>' . $interest_label . '</option>';
                }

            endforeach;
            $output .= '</select>';

            if ($current_interest != '') $output .= ' current id: ' . $current_interest;

            echo $output;
        } else {
            echo 'Could not retrieve mailchimp lists. Please <a href="'. get_admin_url(). 'admin.php?page=mailchimp-for-wp' . '">connect</a> Mailchimp for WP. ';
        }
    }

    private function buildMailchimpInterestsArray($current_list_id) {
        try {
            if (empty($this->mailchimp_interests)) {
                $categories = mc4wp('api')->get_list_interest_categories($current_list_id);
                foreach ($categories as $category):
                    $interests = mc4wp('api')->get_list_interest_category_interests($current_list_id, $category->id);
                    foreach ($interests as $interest):
                        $this->mailchimp_interests[$interest->id] = $category->title . '>' . $interest->name;
                    endforeach;
            endforeach;
            }
        } catch (Exception $e) {
            echo 'Error: ',  $e->getMessage(), ". ";
        }

        return $this->mailchimp_interests;
    }

}
