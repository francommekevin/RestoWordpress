<?php

class ReservationBackoffice
{

    //Gestion du backoffice
    public function admin_index_page()
    {
        ?>
        <style>
            table {
                border: medium solid #000000;
                width: 50%;
                margin: auto;
            }

            td, th {
                border: thin solid #6495ed;
                width: 50%;
            }

            h1 {
                text-align: center;
            }
        </style>

        <h2>Veuillez selectionner une date</h2>
        <div class="form_container"><!-- class de tout le form -->
            <form action="" method="post">

                <label for="Date">Date de Réservation</label>
                <input class="theone" type="date" id="selectDate" name="selectDate" placeholder="JJ/MM/AAAA" required>

                <input type="submit" value="Valider">
            </form>
        </div>


        <?php


        if (isset($_POST["selectDate"]) && !empty($_POST["selectDate"])) {
            global $wpdb;
            $selectDate = $_POST['selectDate'];


            // Interrogation de la base de données
            $resultats = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reservation_restaurant WHERE date_reservation = '$selectDate' ");
            // Parcours des resultats obtenus
                ?>
                <table>
                    <?php echo '<h1>'.get_admin_page_title().'</h1>'; ?>
                    <tr>
                        <th>Date Reservation</th>
                        <th>Id Reservation</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Nombre d'accompagnateurs</th>
                        <th>Email</th>
                        <th>Numero Table</th>
                    </tr>

                    <tr>
                        <?php foreach ($resultats as $post) { ?>
                        <td><?php echo $post->date_reservation ?></td>
                        <td><?php echo $post->id_reservation; ?></td>
                        <td><?php echo $post->nom; ?></td>
                        <td><?php echo $post->prenom; ?></td>
                        <td><?php echo $post->nb_accompagnateur; ?></td>
                        <td><?php echo $post->email; ?></td>
                        <td><?php echo $post->table_reserve; ?></td>
                    </tr>
                <?php } ?>
                </table>
                <?php



        }





    }
}

