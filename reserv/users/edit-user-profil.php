<?php

function edit_user_form() {
    if ( is_user_logged_in() ) {
        $userdata = get_userdata( get_current_user_id() );
        echo '<form action="' . admin_url( 'admin-post.php?action=update_utilisateur' ) . '" method="post" id="update-utilisateur">';

        // Pseudo (ne peut pas être changé)
        echo '<p><label for="pseudo-user">Username</label>';
        echo '<input type="text" name="username" id="pseudo-user" value="' . $userdata->user_login . '" disabled></p>';

        // Nom
        echo '<p><label for="nom-user">Nom</label>';
        echo '<input type="text" name="nom" id="nom-user" value="' . $userdata->last_name . '"></p>';

        // Prénom
        echo '<p><label for="prenom-user">Prénom</label>';
        echo '<input type="text" name="prenom" id="prenom-user" value="' . $userdata->first_name . '"></p>';

        // Nom d'affichage
        echo '<p><label for="display_name-user">Nom d\'affichage</label>';
        echo '<input type="text" name="display_name" id="display_name-user" value="' . $userdata->display_name . '" required></p>';

        // Biographie
        echo '<p><label for="nom-user">Description</label>';
        echo '<textarea name="bio" id="bio-user">' . $userdata->user_description . '</textarea></p>';

        // Site
        echo '<p><label for="site-user">Site web</label>';
        echo '<input type="text" name="site" id="site-user" value="' . $userdata->user_url . '"></p>';

        // Email
        echo '<p><label for="email-user">Email</label>';
        echo '<input type="email" name="email" id="email-user" value="' . $userdata->user_email . '" required></p>';

        // Mot de passe (Mis à jour uniquement si présent)
        echo '<p><label for="pass-user">Mot de passe</label>';
        echo '<input type="password" name="pass" id="pass-user"><br>';
        echo '<input type="checkbox" id="show-password"><label for="show-password">Voir le mot de passe</label></p>';

        // Nonce
        wp_nonce_field( 'update-' . get_current_user_id(), 'user-front' );

        //Validation
        echo '<input type="submit" value="Mettre à jour">';

        echo '</form>';

        // Enqueue de scripts qui vont nous permettre de vérifier les champs
        wp_enqueue_script( 'inscription-front' );
    }
}

// Enregistrement de l'utilisateur
add_action( 'admin_post_update_utilisateur', 'update_utilisateur' );
function update_utilisateur() {
    // Vérifier le nonce
    if( isset( $_POST['user-front'] ) && wp_verify_nonce( $_POST['user-front'], 'update-' . get_current_user_id() ) ) {

        // Vérifier les champs requis
        if ( ! isset( $_POST['email'] ) || ! is_email( $_POST['email'] ) ) {
            wp_redirect( site_url( '/profile/?message=need-email' ) );
            exit();
        }

        // Si l'email change, alors on vérfie qu'elle n'est pas déjà utilisée
        if ( ( $emailuser = email_exists( $_POST['email'] ) ) && get_current_user_id() != $emailuser ) {
            wp_redirect( site_url( '/profile/?message=email-exist' ) );
            exit();
        }

        // Nouvelles valeurs
        $userdata = array(
            'ID' => get_current_user_id(),
            'first_name' => sanitize_text_field( $_POST['prenom'] ),
            'last_name' => sanitize_text_field( $_POST['nom'] ),
            'display_name' => sanitize_text_field( $_POST['display_name'] ),
            'description' => esc_textarea( $_POST['bio'] ),
            'user_email' => sanitize_email( $_POST['email'] ),
            'user_url' => sanitize_url( $_POST['url'] ),
        );

        // On ne met à jour le mot de passe que si un nouveau à été renseigné
        if ( isset( $_POST['pass'] ) && ! empty( $_POST['pass'] ) ) {
            $userdata[ 'user_pass' ] = trim( $_POST['pass'] );
        }

        // Mise à jour de l'utilisateur
        wp_update_user( $userdata );

        // Redirection
        wp_redirect( site_url( '/profile/?message=user-updated' ) );
        exit();
    }
}