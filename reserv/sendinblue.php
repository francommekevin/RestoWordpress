<?php

class ReservationSendinBlue
{
    function afficheReserv()
    {


        // Interrogation de la base de données
        global $wpdb;
        $resultats = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reservation_restaurant WHERE id_reservation = (SELECT MAX(id_reservation) FROM {$wpdb->prefix}reservation_restaurant )");
        // Parcours des resultats obtenus
        ?>
        <table>
            <?php echo '<h1>' . get_admin_page_title() . '</h1>'; ?>
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
                <?php foreach ($resultats

                as $post) { ?>
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

    function qr(){
        ?>
        <script language="javascript" type="text/javascript">
                function process() {
                    var apiurl = "https://chart.googleapis.com/chart";
                    var els = document.forms["theform"].elements;
                    var el;
                    var i = 0;
                    var querystring = "?";
                    while (null != (el = els.item(i++))) {
                        querystring += escape(el.name) + "=" + escape(el.value) + "&";
                    }
                    var resultado = document.getElementById('resultado');
                    var basura = resultado.childNodes;
                    var basurita;
                    i = 0;
                    while (null != (basurita = basura.item(i++))) {
                        resultado.removeChild(basurita);
                    }
                    var img = document.createElement('img');
                    img.src = apiurl + querystring;
                    resultado.appendChild(img);
                    return false;
                }
            </script>

            <h1>QR Code Generator</h1>
            <div>
                <form action="#" onsubmit="return process();" method="POST" id="theform" name="theform">
                    <input type="text" name="chl" id="chl"></input>
                    <select name="chld" id="chld">
                        <option value="L" selected="selected">L (7%)</option>
                        <option value="M">M (15%)</option>
                        <option value="Q">Q (25%)</option>
                        <option value="H">H (30%)</option>
                    </select>
                    <input type="hidden" name="choe" value="UTF-8" id="choe"/>
                    <input type="hidden" name="chs" value="300x300" id="chs"/>
                    <input type="hidden" name="cht" value="qr" id="cht"/>
                    <input type="submit" name="submit" value="QR!"/>
                </form>
            </div>
            <div id="resultado">
            </div>

            <?php
    }

}