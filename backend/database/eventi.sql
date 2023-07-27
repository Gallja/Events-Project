DROP SCHEMA IF EXISTS eventi CASCADE;

CREATE SCHEMA eventi;

CREATE TABLE eventi.utenti (
    email varchar PRIMARY KEY,
    pw varchar NOT NULL CHECK (pw <> '')
);

CREATE TABLE eventi.eventi (
    codice serial PRIMARY KEY,
    nome_evento varchar NOT NULL CHECK (nome_evento <> ''),
    data_evento date NOT NULL,
    luogo varchar NOT NULL CHECK (luogo <> ''),
    descrizione varchar NOT NULL CHECK (descrizione <> '')
);

-- Procedura di inserimento di un nuovo utente:
CREATE OR REPLACE PROCEDURE eventi.insert_utente (
    email varchar,
    pw varchar
) AS $$
BEGIN 
    INSERT INTO eventi.utenti(email, pw)
    VALUES (email, pw);
END;
$$ LANGUAGE plpgsql;

SELECT pg_get_serial_sequence ('eventi.eventi', 'codice');
SELECT setval (pg_get_serial_sequence('eventi.eventi', 'codice'), 1, false);

-- Procedura di inserimento di un nuovo evento:
CREATE OR REPLACE PROCEDURE eventi.insert_evento (
    nome_evento varchar,
    data_evento date,
    luogo varchar,
    descrizione varchar
) AS $$
BEGIN
    INSERT INTO eventi.eventi(nome_evento, data_evento, luogo, descrizione)
    VALUES (nome_evento, data_evento, luogo, descrizione);
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento di un evento esistente:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento (
    codice_in integer,
    nome_evento_in varchar,
    data_evento_in date,
    luogo_in varchar,
    descrizione_in varchar
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET e.nome_evento = nome_evento_in,
        e.data_evento = data_evento_in,
        e.luogo = luogo_in,
        e.descrizione = descrizione_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica della password per un utente:
CREATE OR REPLACE FUNCTION eventi.cambio_pw (
    email_in text,
    old_pw text,
    new_pw text
)
RETURNS INTEGER AS $$
DECLARE
    aggiornato varchar;
BEGIN
    IF EXISTS (
        SELECT 1
        FROM eventi.utenti AS u 
        WHERE u.pw = old_pw
    ) THEN 
        UPDATE eventi.utenti
        SET u.pw = new_pw
        WHERE u.email = email_in
        RETURNING u.email INTO aggiornato;
    END IF;

    IF aggiornato IS NOT NULL
    THEN
        RETURN '1';
    ELSE 
        RETURN '0';
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Funzione di eliminazione di un evento esistente:
CREATE OR REPLACE PROCEDURE eventi.elimina_evento (
    nome_in varchar
)
AS $$
BEGIN
    DELETE FROM eventi.eventi AS e
    WHERE e.nome_evento = nome_in;
END;
$$ LANGUAGE plpgsql;