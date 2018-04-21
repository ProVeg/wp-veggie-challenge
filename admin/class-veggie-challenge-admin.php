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
        add_settings_section(
            $this->option_name . '_vc_gravity_forms',
            __('Gravity Forms', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_render'),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_gravity_forms_form_id',
            __('Gravity Form ID', 'veggie-challenge'),
            array($this, $this->option_name . '_gravity_forms_form_id_render'),
            $this->plugin_name,
            $this->option_name . '_vc_gravity_forms',
            array('label_for' => $this->option_name . '_gravity_forms_form_id')
        );
        register_setting( $this->plugin_name, $this->option_name . '_gravity_forms_form_id' );

        add_settings_section(
            $this->option_name . '_vc_mailchimp',
            __('Mailchimp', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_render'),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_mailchimp_interest_vegan_id',
            __('Vegan interest group ID', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_interest_vegan_id_render'),
            $this->plugin_name,
            $this->option_name . '_vc_mailchimp',
            array('label_for' => $this->option_name . '_mailchimp_interest_vegan_id')
        );

        add_settings_field(
            $this->option_name . '_mailchimp_interest_vegetarian_id',
            __('Vegetarian interest group ID', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_interest_vegetarian_id_render'),
            $this->plugin_name,
            $this->option_name . '_vc_mailchimp',
            array('label_for' => $this->option_name . '_mailchimp_interest_vegetarian_id')
        );

        add_settings_field(
            $this->option_name . '_mailchimp_interest_meatfreedays_id',
            __('Meat Free Days interest group ID', 'veggie-challenge'),
            array($this, $this->option_name . '_mailchimp_interest_meatfreedays_id_render'),
            $this->plugin_name,
            $this->option_name . '_vc_mailchimp',
            array('label_for' => $this->option_name . '_mailchimp_interest_meatfreedays_id')
        );

        register_setting( $this->plugin_name, $this->option_name . '_mailchimp_interest_vegan_id' );
        register_setting( $this->plugin_name, $this->option_name . '_mailchimp_interest_vegetarian_id' );
        register_setting( $this->plugin_name, $this->option_name . '_mailchimp_interest_meatfreedays_id' );
    }


    /**
     * Render the text for the gravity forms section
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_render()
    {
        echo '<p>' . __('Enter the Gravity Forms form ID of the Veggie Challenge.', 'veggie-challenge') . '</p>';
    }

    /**
     * _Render the settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_gravity_forms_form_id_render()
    {
        $form_id = get_option( $this->option_name . '_gravity_forms_form_id' );

        $select = '<select name="' . $this->option_name . '_gravity_forms_form_id' . '" id="' . $this->option_name . '_gravity_forms_form_id' . '" >';
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
     * Render the text for the Mailchimp section
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_render()
    {
        echo '<p>' . __('Enter the Mailchimp interest group IDs.', 'veggie-challenge') . '</p>';
    }

    /**
     * Render the settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_interest_vegan_id_render()
    {
        $form_id = get_option( $this->option_name . '_mailchimp_interest_vegan_id' );
        echo '<input type="text" name="' . $this->option_name . '_mailchimp_interest_vegan_id' . '" id="' . $this->option_name . '_mailchimp_interest_vegan_id' . '" value="' . $form_id . '"> ';
    }

    /**
     * Render the settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_interest_vegetarian_id_render()
    {
        $form_id = get_option( $this->option_name . '_mailchimp_interest_vegetarian_id' );
        echo '<input type="text" name="' . $this->option_name . '_mailchimp_interest_vegetarian_id' . '" id="' . $this->option_name . '_mailchimp_interest_vegetarian_id' . '" value="' . $form_id . '"> ';
    }

    /**
     * Render the settings input field
     *
     * @since  1.0.0
     */
    public function veggie_challenge_mailchimp_interest_meatfreedays_id_render()
    {
        $form_id = get_option( $this->option_name . '_mailchimp_interest_meatfreedays_id' );
        echo '<input type="text" name="' . $this->option_name . '_mailchimp_interest_meatfreedays_id' . '" id="' . $this->option_name . '_mailchimp_interest_meatfreedays_id' . '" value="' . $form_id . '"> ';
    }

}
