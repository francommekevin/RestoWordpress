<?php
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
?>