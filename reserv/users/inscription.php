<?php
// Formulaire d'inscription
function register_user_form() {
    echo '<form action="' . admin_url( 'admin-post.php?action=nouvel_utilisateur' ) . '" method="post" id="register-user">';

    // Les champs requis
    echo '<p><label for="nom-user">Nom</label><input type="text" name="username" id="nom-user" required></p>';
    echo '<p><label for="email-user">Email</label><input type="email" name="email" id="email-user" required></p>';
    echo '<p><label for="pass-user">Mot de passe</label><input type="password" name="pass" id="pass-user" required><br>';
    echo '<input type="checkbox" id="show-password"><label for="show-password">Voir le mot de passe</label></p>';

    // Nonce (pour vérifier plus tard que l'action a bien été initié par l'utilisateur)
    wp_nonce_field( 'create-' . $_SERVER['REMOTE_ADDR'], 'user-front', false );

    //Validation
    echo '<input type="submit" value="Créer mon compte">';
    echo '</form>';

    // Enqueue de scripts qui vont nous permettre de vérifier les champs
    wp_enqueue_script( 'inscription-front' );
}

// Enregistrement de l'utilisateur
add_action( 'admin_post_nopriv_nouvel_utilisateur', 'ajouter_utilisateur' );
function ajouter_utilisateur() {
    // Vérifier le nonce (et n'exécuter l'action que s'il est valide)
    if( isset( $_POST['user-front'] ) && wp_verify_nonce( $_POST['user-front'], 'create-' . $_SERVER['REMOTE_ADDR'] ) ) {

        // Vérifier les champs requis
        if ( ! isset( $_POST['username'] ) || ! isset( $_POST['email'] ) || ! isset( $_POST['pass'] ) ) {
            wp_redirect( site_url( '/inscription/?message=not-user' ) );
            exit();
        }

        $nom = $_POST['username'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        // Vérifier que l'user (email ou nom) n'existe pas
        if ( is_email( $email ) && ! username_exists( $nom )  && ! email_exists( $email ) ) {
            // Création de l'utilisateur
            $user_id = wp_create_user( $nom, $pass, $email );
            $user = new WP_User( $user_id );
            // On lui attribue un rôle
            $user->set_role( 'subscriber' );
            // Envoie un mail de notification au nouvel utilisateur
            wp_new_user_notification( $user_id, $pass );
        } else {
            wp_redirect( site_url( '/inscription/?message=already-registered' ) );
            exit();
        }

        // Connecter automatiquement le nouvel utilisateur
        $creds = array();
        $creds['user_login'] = $nom;
        $creds['user_password'] = $pass;
        $creds['remember'] = false;
        $user = wp_signon( $creds, false );

        // Redirection
        wp_redirect( site_url( '/?message=welcome' ) );
        exit();
    }
}

// Il faut register les scripts que notre formualire utilise
add_action( 'wp_enqueue_scripts', 'register_login_script' );
function register_login_script() {
    wp_register_script( 'inscription-front', get_template_directory_uri() . '/js/inscription.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'message', get_template_directory_uri() . '/js/message.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'jquery' );

    // Ce script sera chargé sur toutes les pages du site, afin d'afficher les messages d'erreur
    wp_enqueue_script( 'message' );
}

add_action( 'wp_footer', 'show_user_registration_message' );
function show_user_registration_message() {
    if ( isset( $_GET['message'] ) ) {
        $wrapper = '<div class="message">%s</div>';
        switch ( $_GET['message'] ) {
            case 'already-registred':
                echo wp_sprintf( $wrapper, 'Un utilisateur possède la même adresse.' );
                break;
            case 'not-user':
                echo wp_sprintf( $wrapper, 'Votre inscription a échouée.' );
                break;
            case 'user-updated':
                echo wp_sprintf( $wrapper, 'Votre profil a été mis à jour.' );
                break;
            case 'need-email':
                echo wp_sprintf( $wrapper, 'Votre profil \'a pas été mis à jour. L\'email doit être renseignée.' );
                break;
            case 'email-exist':
                echo wp_sprintf( $wrapper, 'Votre profil \'a pas été mis à jour. L\'adresse email est déjà utilisée.' );
                break;
            case 'welcome':
                echo wp_sprintf( $wrapper, 'Votre compte a été créé. Vous allez recevoir un email de confirmation.' );
                break;
            default :
        }
    }
}