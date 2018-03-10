<?php
function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['date'],
        $_POST['accompagnement']
        );
         
        // sanitize user form input
        global $nom, $prenom, $email, $date, $accompagnement;
        $nom   =   sanitize_user( $_POST['nom'] );
        $prenom   =   esc_attr( $_POST['prenom'] );
        $email      =   sanitize_email( $_POST['email'] );
        $date    =   esc_url( $_POST['date'] );
        $accompagnement =   sanitize_text_field( $_POST['accompagnement'] );
        
        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
        $nom,
        $prenom,
        $email,
        $date,
        $accompagnement
        );
    }
 
    registration_form(
        $nom,
        $prenom,
        $email,
        $date,
        $accompagnement
        );
}
// Register a new shortcode: [cr_custom_registration]
add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
?>
 