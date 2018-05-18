<?php

/*
Plugin Name: Reserv
Description: Plugin de réservation de restauration
Version: 1.0.0
Author: Kevin
*/


class ReservationPlugin {

    function __construct(){

        //Include des fichiers
        include_once plugin_dir_path( __FILE__ ).'/formulaire.php';
        new ReservationFormulaire();

        include_once plugin_dir_path( __FILE__ ).'/backoffice.php';
        new ReservationBackoffice();

        include_once plugin_dir_path( __FILE__ ).'/sendinblue.php';
        new ReservationSendinBlue();



        //Appel des actions
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) ); //wp veut dire travailler en front
        add_action( 'admin_menu', array( $this, 'add_admin_pages') );


        //Appel des fonctions Hook
        register_activation_hook(__FILE__, array($this, 'install'));
        register_uninstall_hook(__FILE__, array($this, 'uninstall'));

        //Appel des shortcodes
        add_shortcode( 'reservation_formulaire', 'reservation_shortcode' );

    }

    //Creation des tables à l'installation du plugin
    public static function install()
    {
        global $wpdb;

        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}reservation_restaurant(id_reservation INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(25) NOT NULL, prenom VARCHAR(25) NOT NULL , nb_accompagnateur INT(2) NOT NULL, date_reservation DATETIME NOT NULL , email VARCHAR(255) NOT NULL);");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}table_restaurant(id_table INT AUTO_INCREMENT PRIMARY KEY, date_reservation DATETIME, id_reservation INT(255))");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dispo_restaurant(date_reservation DATETIME, id_reservation INT(255), id_table INT(255), conpteur_midi INT(2), compteur_soir INT(2))");

    }

    //Suppression des tables à la suppression du plugin
    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}reservation_restaurant;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}table_restaurant;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}dispo_restaurant;");
    }

    //Ajout menu dans le Backoffice
    public function add_admin_pages()
    {
        add_menu_page('Liste des reservations', 'Restaurant', 'manage_options', 'ReservationPlugin', array('ReservationBackoffice', 'admin_index_page'), 'dashicons-id-alt', 110);

        $hook = add_submenu_page('ReservationPlugin', 'Gestion de SendinBlue', 'QR Code', 'manage_options', 'ReservationSendinBlue', array('ReservationSendinBlue', 'qr'));

        add_action('load-'.$hook, array($this, 'process_action'));

    }


    //Definition du style
    function  enqueue(){
        wp_enqueue_style( 'reservation_styles', plugins_url( '/assets/css/mystyles.css',  __FILE__ ) );// this is for css

    }

}

new ReservationPlugin();


////// html form //////////////
function html_form_code()
{
    ?>

    <!-- Trigger/Open The Modal -->
    <button id="myBtn" xmlns="http://www.w3.org/1999/html">Reservation</button>

    <!-- The Modal -->
    <div id="reservationformjs" class="reserstyle">

        <!-- Modal content -->
        <div class="reserstyle-content">

            <div class="reserstyle-header">

                <span class="close">&times;</span>
                <h2 class="reservationtitle">Reservez dans votre restaurant</h2>

            </div>

            <div class="reserstyle-body">


                <!---     //////////////form/////////////////                 -->

                <h2>Veuillez remplir le formulaire ci-dessous</h2>
                <div class="form_container"><!-- class de tout le form -->
                    <form action="" method="post">
                        <label for="Nom">Nom</label>
                        <input class="theone"  value="<?php echo get_user_meta(get_current_user_id(), 'nom', true); ?>"type="text" id="Nom" name="Nom" placeholder="Nom" required>

                        <label for="Prenom">Prenom</label>
                        <input class="theone" value="<?php echo get_user_meta(get_current_user_id(), 'prenom', true); ?>" type="text" id="Prenom" name="Prenom" placeholder="Prenom" required>

                        <label for="Tele">Numero de téléphone</label>
                        <input class="theone" value="<?php echo get_user_meta(get_current_user_id(), 'telephone', true); ?>" type="tel" id="Tele" name="Tele" placeholder="Téléphone" required>

                        <label for="Date">Date de Réservation</label>
                        <input class="theone" type="datetime-local" id="Date" name="Date" placeholder="JJ/MM/AAAA" required>

                        <label for="nombre_personne">Nombre d'accompagnateurs</label>
                        <input class="theone" type="number" id="nombre_personne" name="nombre_personne" placeholder="1/2">

                        <label for="Email">Entre votre adresse mail</label>
                        <input class="theone" value="<?php echo get_user_meta(get_current_user_id(), 'email', true); ?>" type="email" id="Email" name="Email" placeholder="mail@mail.com" required>

                        <br>
                        <input type="submit" value="Valider votre inscription">
                    </form>
                </div>

                <!---     //////////////end form/////////////////                 -->

            </div>

            <div class="reserstyle-footer">
            </div>

        </div>

    </div>


    <script>

        // Get the modal
        var modal = document.getElementById('reservationformjs');

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>

    <?php

}

function reservation_shortcode() {

    ob_start();
    html_form_code();
    return ob_get_clean();
}


?>