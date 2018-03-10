<?php

/*
  Plugin Name: reservation Form
  Plugin URI: http://localhost:8080/wordpress-4.9.4-fr_fr/wordpress/page-d-exemple/
  Description: Updates user rating based on number of posts.
  Version: 1.0
  Author: Zineb
 */
 //add_action('admin_menu', 'example_admin_menu');
 
/**
* add external link to Tools area
*/
/*function example_admin_menu() {
    global $submenu;
    $url = 'http://localhost:8080/wordpress-4.9.4-fr_fr/wordpress/page-d-exemple/';
    $submenu['tools.php'][] = array('Example', 'manage_options', $url);
}*/


require "registration_form.php";
require"registration_validation.php";
require"custom_registration.php";
require"complete_registration.php";
require"registration_shortcode.php";
?>