<?php
/*
  Plugin Name: reservation Form
  Plugin URI: http://localhost:8080/wordpress-4.9.4-fr_fr/wordpress/page-d-exemple/
  Description: Updates user rating based on number of posts.
  Version: 1.0
  Author: Zineb
 */
 function registration_form( $nom, $prenom, $email, $date, $accompagnement ) {
	 global $wp_styles;
        foreach( $wp_styles->queue as $handle ) :
    echo  '
    <style>
    div {
        margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
    </style>
    ';
	        endforeach;

 
    echo '
    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
    <div>
    <label for="accompagnement">accompagnement</label>
    <select name="accompagnement">
    <option value="1 personne">1 personne</option>
    <option value="2 personne">2 personne</option>
</select> 
     <value="accompagnement' . ( isset( $_POST['accompagnement']) ? $accompagnement : null ) . '">
    </div>
	<div>
    <label for="nom">Nom <strong>*</strong></label>
    <input type="text" name="nom" value="' . ( isset( $_POST['nom'] ) ? $nom : null ) . '">
    </div>
     
    <div>
    <label for="prenom">Prenom <strong>*</strong></label>
    <input type="text" name="prenom" value="' . ( isset( $_POST['prenom'] ) ? $prenom : null ) . '">
    </div>
     
    <div>
    <label for="email">Email <strong>*</strong></label>
    <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
    </div>
     
    <div>
    <label for="date">Date</label>
    <input type="date" name="date" value="' . ( isset( $_POST['date']) ? $date : null ) . '">
    </div>
    <input type="submit" name="submit" value="Register"/>
    </form>
    ';
}
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
 
// The callback function that will replace [book]
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
	
}
?>