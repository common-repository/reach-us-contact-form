<?php
/*
Plugin Name: Contact Form for Wordpress- Cybrosys
Plugin URI: https://wordpress.org/plugins/reach-us-contact-form/
Description: Cybrosys Technologies has crafted a new plugin that tailors to the exact requirement of a contact page in a website.Contact Form for Wordpress- Cybrosys plugin aims to perform contact operations in a contact page in WordPress Powered websites using [reach_us] shortcode.
Version: 5.0
Author: Cybrosys Technologies
Author URI: http://cybrosys.com
Text Domain: reach-us-contact-form
Domain Path: /languages/
License: GPL2
Copyright:2018 Cybrosys Technologies
*/
                                                        //***FREEMIUM***//
// Create a helper function for easy SDK access.
function rscf() {
    global $rscf;

    if ( ! isset( $rscf ) ) {
        // Activate multisite network integration.
        if ( ! defined( 'WP_FS__PRODUCT_2592_MULTISITE' ) ) {
            define( 'WP_FS__PRODUCT_2592_MULTISITE', true );
        }

        // Include Freemius SDK.
        require_once dirname(__FILE__) . '/freemius/start.php';

        $rscf = fs_dynamic_init( array(
            'id'                  => '2592',
            'slug'                => 'reach-us-contact-form',
            'type'                => 'plugin',
            'public_key'          => 'pk_fe661a7d51fd0301641e8318ba887',
            'is_premium'          => false,
            'has_addons'          => false,
            'has_paid_plans'      => false,
            'menu'                => array(
                'first-path'     => 'plugins.php',
            ),
        ) );
    }

    return $rscf;
}

// Init Freemius.
rscf();
// Signal that SDK was initiated.
do_action( 'rscf_loaded' );
                                
                                    //***PLUGIN ACTION***//
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS', '5.0' );
if ( ! defined( 'WPINC' ) ) {
    die;
}
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS', 'Contact Form for Wordpress- Cybrosys' );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_SLUG', 'reach-us-contact-form' );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_API_VERSION', '5.0' );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_USELL_LINK', 'https://wordpress.org/plugins/reach-us-contact-form/' );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_URL', plugin_dir_url( __FILE__ ) );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_BASENAME', plugin_basename( __FILE__ ) );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_BASEFILE', __FILE__ );
define( 'CONTACT FORM FOR WORDPRESS- CYBROSYS_DEBUG', true );
           
                                                 //***ACTIVATION && DEACTIVATION***//
function activate_rscf_forms() {
    function activate() {}
}

function deactivate_rscf_forms() {
    function deactivate() {}
   
}
register_activation_hook( __FILE__, 'activate_rscf_forms' );
register_deactivation_hook( __FILE__, 'deactivate_rscf_forms' );
                                                    
                                                    //***STYLE***//
function rscf_scripts() {   
    if(!is_admin()) {
        wp_enqueue_style('rscf_style', plugins_url('/assets/css/style.css',__FILE__));
        wp_enqueue_style('rscf_style',plugins_url( '/assets/icon-128x128.svg', __FILE__ ));
        plugin_dir_url( __FILE__ ) . '/assets/icon-128x128.png';
    }
}
add_action('wp_enqueue_scripts', 'rscf_scripts');
                                            
                                            //***LANGUAGE SUPPORT***//
function rscf_textdomain() {
load_plugin_textdomain( 'rscf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'rscf_textdomain' );
                                            
                                            //***RATE THIS PLUGIN***//
function add_rscf_links($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $href  = 'https://wordpress.org/support/plugin/reach-us-contact-form/reviews/#new-post';
        $title = esc_html__('Give us a 5-star rating at WordPress.org', 'rscf');
        $text  = esc_html__('Rate this plugin', 'rscf') .'&nbsp;&raquo;';
        $links[] = '<a target="_blank" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
    }
    return $links;  
}
add_filter('plugin_row_meta', 'add_rscf_links', 10, 2);
                                            
                                            //***CONTACT FORM ***//
function rscf_form_code() { ?>
    <div class="wrap reach-us">
    <?php
    echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post" class="pre">';
    echo '<label>';
    _e('Your Name:','reach-us-contact-form');
    echo '<input type="text" name="yourname" required aria-required=”true”  pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["yourname"] ) ? esc_attr( $_POST["yourname"] ) : '' ) . '" size="40" />';
    echo '</label>';
    echo '<label>';
    _e('Your Email:','reach-us-contact-form');
    echo '<input type="email" name="mail" required aria-required=”true”  value="' . ( isset( $_POST["mail"] ) ? esc_attr( $_POST["mail"] ) : '' ) . '" size="40" />';
    echo '</label>';
    echo '<label>';
    _e('Subject:','reach-us-contact-form');
    echo '<input type="text" name="subject" required aria-required=”true”  pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["subject"] ) ? esc_attr( $_POST["subject"] ) : '' ) . '" size="40" />';
    echo '</label>';
    echo '<label>';
    _e('Message:','reach-us-contact-form');
    echo '<textarea rows="10" cols="35" name="message" required aria-required=”true” >' . ( isset( $_POST["message"] ) ? esc_attr( $_POST["message"] ) : '' ) . '</textarea>';
    echo '</label>';?>
    <label>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="g-recaptcha" data-sitekey="<?php echo sanitize_text_field( get_option( 'rscf_publickey' ) ) ?>"></div></label>
    <?php
    echo '<label>';
    echo '<button type="submit" name="rscf-submit" value="Contact Us"/>';
    _e('Contact Us','reach-us-contact-form');
    echo '</label>';
    echo '</form>';
    echo '</div>' ; 
        
}
function rscf_mail() {
    if ( isset( $_POST["rscf-submit"] ) ) {
        $name    = sanitize_text_field( $_POST["yourname"] );
        $email   = sanitize_email( $_POST["mail"] );
        $subject = sanitize_text_field( $_POST["subject"] );
        $message = esc_textarea( $_POST["message"] );
        $to = get_option( 'admin_email' );
        $headers = "From: $name <$email>" . "\r\n";
        if ( wp_mail( $to, $subject, $message, $headers ) ) {
            echo '<div>';
            _e ('Thanks for contacting us,Expect a reply soon...','reach-us-contact-form');;
            echo '</div>';
        } else {
            _e ('Enter correct details!!','reach-us-contact-form');;
        }
    }
}
                                            //***SHORTCODE***//
function rscf_shortcode() {
    ob_start();
    rscf_mail();
    rscf_form_code();
    return ob_get_clean();
}
add_shortcode( 'reach_us', 'rscf_shortcode' );

                                             //***SETTINGS PAGE***//
add_action( 'admin_menu', 'rscf_setup_menu' );
add_action( 'admin_init', 'rscf_register_settings' );

function rscf_register_settings() {
    register_setting( 'rscf-option-group', 'rscf_publickey' );
    register_setting( 'rscf-option-group', 'rscf_privatekey' );
    register_setting( 'rscf-option-group', 'rscf_mailto' );
    register_setting( 'rscf-option-group', 'rscf_subject' );
    register_setting( 'rscf-option-group', 'rscf_placeholders' );
    register_setting( 'rscf-option-group', 'rscf_invisible' );
    register_setting( 'rscf-option-group', 'rscf_redirect' );
}

function rscf_setup_menu() {
    add_options_page( 'Contact Form Settings', 'Contact Form Settings', 'manage_options', 'rscf',
        'rscf_init' );
}

function rscf_init() {
    ?>
    
   <div class="wrap">

        <h1><?php _e( 'Contact Form for WordPress - Cybrosys', 'reach-us-contact-form' ); ?>
            <a target="_blank" class="page-title-action" href="https://www.google.com/recaptcha/admin">
                <span class="dashicons-before dashicons-external"></span> <?php _e( 'Get your keys',
                    'reach-us-contact-form' ); ?>
            </a>
        </h1>

        <form method="post" action="options.php">
            <?php settings_fields( 'rscf-option-group' ) ?>
            <?php do_settings_sections( 'rscf-option-group' ) ?>

            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="rscf_publickey">
                            <?php _e( 'Public Key', 'reach-us-contact-form' ); ?>
                        </label>
                    </th>
                    <td>
                        <input id="rscf_publickey" type="text" name="rscf_publickey"
                               value="<?php echo esc_attr( get_option( 'rscf_publickey' ) ) ?>"
                               class="regular-text"/>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="rscf_privatekey">
                            <?php _e( 'Secret Key', 'reach-us-contact-form' ); ?>
                        </label>
                    </th>
                    <td>
                        <input id="rscf_privatekey" type="text" name="rscf_privatekey"
                               value="<?php echo esc_attr( get_option( 'rscf_privatekey' ) ) ?>"
                               class="regular-text">
                    </td>
                </tr>
                </tbody>
            </table>

            <?php submit_button() ?>
        </form>
    </div>
      


        <h1><u><?php _e( 'Contact Form for Wordpress- Cybrosys', 'reach-us-contact-form' ); ?></u></h1>
    
        <h2 class="title"><?php _e( 'Usage', 'reach-us-contact-form' ); ?></h2>

        <p><?php _e( 'After installation, you may insert the shortcode <code>[reach_us]</code> on pages or posts to display the contact form.',
                'reach-us-contact-form' ); ?></p>

        <h2 class="title"><?php _e( 'Had a Wonderful Time Enjoying the Plugin?', 'reach-us-contact-form' ); ?></h2>

        <p><?php _e( 'If this Plugin has done its job saving your time, <a href="https://wordpress.org/support/plugin/reach-us-contact-form">Leave a review</a> and spread the word. </a>.',
                'reach-us-contact-form' ); ?></p>
   
    <?php
}
