<?php
/*
Plugin Name: reservation
Description: Un plugin de reservation
Version: 0.1
Author: Francomme Kevin
*/

add_filter('wp_title', 'zero_modify_page_title', 20) ;
function zero_modify_page_title($title) {
    return $title . ' | Avec le plugin des zéros !' ;
}