<?php
    if (isset($_POST['codice'])) {
        if (isset($_POST['nome_evento'])) {
            echo "entrato2";
        } else {
            if (isset ($_POST['data_evento'])) {
                echo "entrato3";
            } else {
                if (isset($_POST['luogo'])) {
                    echo "entrato4";
                } else {
                    if (isset($_POST['immagine'])) {
                        echo "entrato5";
                    } else {
                        if (isset($_POST['descrizione'])) {
                            echo "entrato6";
                        } else {
                            echo "errore";
                        }
                    }
                }
            }
        }
    } else {
        echo "errore";
    }
?>