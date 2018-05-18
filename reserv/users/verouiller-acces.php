<?php

// Vérouiller l'accès à une page
add_action( 'template_redirect', 'private_page' );
function private_page() {
    if ( is_page(5) && ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink(5) ) );
        exit();
    }
}


// Vérouiller l'accès à un type de page
add_action( 'template_redirect', 'private_type_of_page' );
function private_type_of_page() {
    if ( is_page_template( 'private-page.php' ) && ! is_user_logged_in() ) {
        wp_redirect( wp_login_url() );
        exit();
    }
}


// Vérouiller l'accès à tout le site
// Utiliser une page de connexion en front
add_action( 'template_redirect', 'private_website' );
function private_website() {
    //si l'utilisateur n'est pas connecté, l'envoyer vers la page de connexion
    if ( ! is_user_logged_in() && ! is_page( 'login' ) ) {
        // Page de login custom
        wp_redirect( home_url( '/login/' ) );
        exit();
    }
    //interdire aux utilisateurs loggés d'aller sur la page de connexion
    elseif ( is_user_logged_in() && is_page( 'login' ) ) {
        wp_redirect( home_url( '/' ) );
        exit();
    }
}


//interdire l'accès aux non admins
add_action( 'current_screen', 'redirect_non_authorized_user' );
function redirect_non_authorized_user() {
    // Si t'es pas admin, tu vires
    if ( is_user_logged_in() && ! current_user_can( 'manage_options' ) ) {
        wp_redirect( home_url( '/' ) );
        exit();
    }
}


// Proposer un contenu uniques aux utilisateurs autorisés
add_shortcode( 'private-content', 'private_content' );
function private_content( $atts, $content ) {
    if ( is_user_logged_in() ) {
        return $content;
    } else {
        // Affiche un lien vers la page login de WordPress,
        // puis redirige ensuite automatiquement vers la page précédente
        return '<a href="' . wp_login_url( get_permalink() ) . '">Connectez-vous pour lire ce contenu</a>';
    }
}