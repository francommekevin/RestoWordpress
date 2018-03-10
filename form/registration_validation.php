<?php
function registration_validation( $nom, $prenom, $email, $date, $accompagnement )  {
global $reg_errors;
$reg_errors = new WP_Error;
if ( empty( $nom ) || empty( $prenom ) || empty( $email ) ) {
    $reg_errors->add('field', 'Required form field is missing');
}
    }

if ( is_wp_error( $reg_errors ) ) {
 
    foreach ( $reg_errors->get_error_messages() as $error ) {
     
        echo '<div>';
        echo '<strong>ERROR</strong>:';
        echo $error . '<br/>';
        echo '</div>';
         
    }
}
