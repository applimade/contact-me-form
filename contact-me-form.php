<?php
/*
    Plugin Name: Contact Me Form
    Plugin URI: http://applimade.com/contact-me-form/
    Description: Simple contact me form for Wordpress
    Version: 1.0
    Author: Applimade
    Author URI: http://applimade.com
*/
    function contact_me_form() {
        echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';
        echo '<p>';
        echo 'Your Name (required) <br />';
        echo '<input type="text" name="cmf-name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cmf-name"] ) ? esc_attr( $_POST["cmf-name"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Your Email (required) <br />';
        echo '<input type="email" name="cmf-email" value="' . ( isset( $_POST["cmf-email"] ) ? esc_attr( $_POST["cmf-email"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Subject (required) <br />';
        echo '<input type="text" name="cmf-subject" pattern="[a-zA-Z ]+" value="' . ( isset( $_POST["cmf-subject"] ) ? esc_attr( $_POST["cmf-subject"] ) : '' ) . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Your Message (required) <br />';
        echo '<textarea rows="10" cols="35" name="cmf-message">' . ( isset( $_POST["cmf-message"] ) ? esc_attr( $_POST["cmf-message"] ) : '' ) . '</textarea>';
        echo '</p>';
        echo '<p><input type="submit" name="cmf-submitted" value="Submit"/></p>';
        echo '</form>';
    }

    function deliver_mail() {

        // if the submit button is clicked, send the email
        if ( isset( $_POST['cmf-submitted'] ) ) {
    
            // sanitize form values
            $name    = sanitize_text_field( $_POST["cmf-name"] );
            $email   = sanitize_email( $_POST["cmf-email"] );
            $subject = sanitize_text_field( $_POST["cmf-subject"] );
            $message = esc_textarea( $_POST["cmf-message"] );
    
            // get the blog administrator's email address
            $to = get_option( 'admin_email' );
    
            $headers = "From: $name <$email>" . "\r\n";
    
            // If email has been process for sending, display a success message
            if ( wp_mail( $to, $subject, $message, $headers ) ) {
                echo '<div>';
                echo '<p>Thanks for contacting me! I will get back to you within 24 hours.</p>';
                echo '</div>';
            } else {
                echo 'An unexpected error occurred';
            }
        }
    }

    function cmf_shortcode() {
        ob_start();
        deliver_mail();
        contact_me_form();
    
        return ob_get_clean();
    }

    add_shortcode('contact_me_form', 'cmf_shortcode');
?>
