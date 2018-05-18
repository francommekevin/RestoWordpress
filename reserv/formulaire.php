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

                if($table <=15){
                    $h1 = $dateReservation;
                $h2=strtotime("18:00:00");
                $h3=strtotime("23:00:00");
                if(date('H:i', $h2 < $h1 && $h1 < $h3))
                {

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
                    require('Mailin.php');
                    $mailin = new Mailin("https://api.sendinblue.com/v2.0","DXwfInCNY7GHdp6B");
                    $data = array( "to" => array("$email" =>"$nom"),
                    "from" => array("kevin_francomme@hotmail.fr", "L équipe du Restaurant"),
                    "subject" => "Votre réservation",
                    "html" => "Votre réservation à été prise en compte, utilisé ce QR Code afin de vérifier celle-ci.",
                    );

                    var_dump($mailin->send_email($data));
                }else{
                    ?>
                    <style>
                        .error {
                            color: #D8000C;
                            background-color: #FFBABA;

                        }
                    </style>
                    <div class="error">Désolé, vous pouvez pas reserver en dehors des horaires du restaurant. (18h-23h)</div>
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
