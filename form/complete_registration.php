<?php
function complete_registration() {
    global $reg_errors, $nom, $prenom, $email, $date, $accompagnement;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'nom'    =>   $nom,
        'email'    =>   $email,
        'prenom' =>$prenom,
        'date'      =>   $date,
        'accompagnement'    =>   $accompagnement,
        
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';   
    }
}
?>