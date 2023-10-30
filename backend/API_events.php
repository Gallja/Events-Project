<?php
    header('Content-Type: application/json');

    // open connection to DB
    include_once('backend\web app\script\management\connection.php');

    // API request - only read events
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // endpoint

        if (isset($_GET['evento_id'])) {
            $evento_id = $_GET['evento_id'];

            $result_comici = pg_query($connection, "SELECT e.codice, e.nome_evento, e.data_evento, e.ora_evento, e.luogo, e.link_biglietto,
                                                           c.nome_comico, c.cognome_comico
                                                    FROM eventi.comici AS c 
                                                    INNER JOIN eventi.eventi_comici AS ec
                                                    ON c.id = ec.comico
                                                    INNER JOIN eventi.eventi AS e
                                                    ON ec.evento = e.codice
                                                    WHERE ec.evento = $evento_id");

            $eventi_comici = pg_fetch_all($result_comici);

            $result_musicisti = pg_query($connection, "SELECT e.nome_evento, e.data_evento, e.ora_evento, e.luogo, e.descrizione, e.link_biglietto,
                                                              m.nome_musicista
                                                       FROM eventi.musicisti AS m
                                                       INNER JOIN eventi.eventi_musicisti AS em
                                                       ON m.id_musicista = em.musicista
                                                       INNER JOIN eventi.eventi AS e
                                                       ON em.evento = e.codice
                                                       WHERE em.evento = $evento_id");

            $eventi_musicisti = pg_fetch_all($result_musicisti);

            $response['eventi_comici'] = $eventi_comici;
            $response['eventi_musicisti'] = $eventi_musicisti;
        }

        $result = pg_query($connection, "SELECT e.codice, e.nome_evento, e.data_evento, e.ora_evento,
                                                e.luogo, encode(e.immagine, 'base64') AS immagine, e.descrizione
                                         FROM eventi.eventi AS e
                                         WHERE e.data_evento >= CURRENT_DATE");
        $eventi = pg_fetch_all($result);

        $result2 = pg_query($connection, "SELECT c.id, c.nome_comico, c.cognome_comico, encode(c.profilo, 'base64') AS immagine, c.bio
                                          FROM eventi.comici AS c");
        $comici = pg_fetch_all($result2);

        $result3 = pg_query($connection, "SELECT m.id_musicista, m.nome_musicista, encode(m.profilo_musicista, 'base64') AS immagine, m.bio_musicista 
                                          FROM eventi.musicisti AS m");
        $musicisti = pg_fetch_all($result3);

        $result4 = pg_query($connection, "SELECT e.codice, e.nome_evento, e.data_evento,
                                                 e.luogo, encode(e.immagine, 'base64') AS immagine, e.descrizione
                                          FROM eventi.eventi AS e
                                          WHERE e.data_evento < CURRENT_DATE");
        $archivio_eventi = pg_fetch_all($result4);

        $response['eventi'] = $eventi;
        $response['comici'] = $comici;
        $response['musicisti'] = $musicisti;
        $response['archivio_eventi'] = $archivio_eventi;

        // JSON encoding
        echo json_encode($response);
    } 

    // close connection to the DB
    pg_close($connection);
?>