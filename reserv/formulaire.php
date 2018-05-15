<?php

class ReservationFormulaire
{

    public function __construct()
    {
        add_action('wp_loaded', array($this, 'save_reservation'));
    }

    public function save_reservation()
    {
        if (isset($_POST['Email'], $_POST['Nom'], $_POST['Prenom'], $_POST['nombre_personne'], $_POST["Date"], $_POST['Tele'])
            && !empty($_POST['Email']) && !empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['nombre_personne']) && !empty($_POST["Date"]) && !empty($_POST['Tele']))
        {
            global $wpdb;
            $email = $_POST['Email'];
            $nom = $_POST['Nom'];
            $prenom = $_POST['Prenom'];
            $nbAccompagnateur = $_POST['nombre_personne'];
            $dateReservation = $_POST['Date'];
            $telephone = $_POST['Tele'];


            $dateFr = strftime('%d-%m-%Y',strtotime($dateReservation));

            $dateSelect = new DateTime($dateFr);
            $dateAuj = new DateTime();
            $interval = $dateSelect->diff($dateAuj);
            $diff = $interval->format('%a');
            $diff = $diff + 1;

            if( $diff <= 10){
                $count = $wpdb->get_var("SELECT COUNT(id_reservation) FROM {$wpdb->prefix}reservation_restaurant WHERE date_reservation = '$dateReservation'");
                $table = $count + 1;

                if($table <=3){
                    $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}reservation_restaurant WHERE email = '$email'");
                    $wpdb->insert("{$wpdb->prefix}reservation_restaurant", array('nom' => $nom, 'prenom' => $prenom, 'nb_accompagnateur' => $nbAccompagnateur, 'date_reservation' => $dateReservation, 'email' => $email, 'telephone' => $telephone, 'table_reserve' => $table));
                    ?>
                    <style>
                        .error {
                            color: black;
                            background-color: lawngreen;

                        }
                    </style>
                    <div class="error">Votre reservation à été pris en compte</div>
                    <?php
                }else{
                        ?>
                        <style>
                        .error {
                            color: #D8000C;
                            background-color: #FFBABA;

                        }
                    </style>
                    <div class="error">Désolé, nous n'avons plus de table disponible à ce jour</div>
                    <?
                }



            }else{
                ?>
                <style>
                    .error {
                        color: #D8000C;
                        background-color: #FFBABA;

                    }
                </style>
                <div class="error">Vous ne pouvez pas reserver plus de 10j en avance</div>
                <?php

            }






        }

    }
}
