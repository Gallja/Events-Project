DROP SCHEMA IF EXISTS eventi CASCADE;

CREATE SCHEMA eventi;

-- Tabella utenti ammessi nel sistema:
CREATE TABLE eventi.utenti (
    email varchar PRIMARY KEY,
    pw varchar NOT NULL CHECK (pw <> '')
);

-- Tabella degli eventi:
CREATE TABLE eventi.eventi (
    codice serial PRIMARY KEY,
    nome_evento varchar NOT NULL CHECK (nome_evento <> ''),
    data_evento date NOT NULL,
    luogo varchar NOT NULL CHECK (luogo <> ''),
    immagine bytea NOT NULL,
    descrizione varchar NOT NULL CHECK (descrizione <> '')
);

-- Tabella dei comici:
CREATE TABLE eventi.comici (
    id serial PRIMARY KEY,
    nome_comico varchar NOT NULL CHECK (nome_comico <> ''),
    cognome_comico varchar NOT NULL CHECK (cognome_comico <> ''),
    foto_profilo bytea NOT NULL,
    bio_comico varchar NOT NULL CHECK (bio_comico <> '')
);

-- Tabella di associazione tra eventi e comici:
CREATE TABLE eventi.eventi_comici (
    evento integer NOT NULL,
        FOREIGN KEY (evento) REFERENCES eventi.eventi ON DELETE CASCADE,
    comico integer NOT NULL,
        FOREIGN KEY (comico) REFERENCES eventi.comici ON DELETE CASCADE,
    PRIMARY KEY (evento, comico)    
);

-- Vista materializzata che mette in relazione eventi e comici:
CREATE OR REPLACE VIEW eventi.vista_eventi_completi AS
    SELECT e.*, c.*
    FROM eventi.eventi AS e 
    JOIN eventi.eventi_comici AS ec 
    ON e.codice = ec.evento 
    JOIN eventi.comici AS c 
    ON ec.comico = c.id;

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
    immagine bytea,
    descrizione varchar
) AS $$
BEGIN
    INSERT INTO eventi.eventi(nome_evento, data_evento, luogo, immagine, descrizione)
    VALUES (nome_evento, data_evento, luogo, immagine, descrizione);
END;
$$ LANGUAGE plpgsql;

-- Procedura di inserimento di un nuovo comico:
CREATE OR REPLACE PROCEDURE eventi.insert_comico (
    nome_comico varchar,
    cognome_comico varchar,
    foto_profilo bytea,
    bio_comico varchar
) AS $$
BEGIN
    INSERT INTO eventi.comici(nome_comico, cognome_comico, foto_profilo, bio_comico)
    VALUES(nome_comico, cognome_comico, foto_profilo, bio_comico);
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
        SET pw = new_pw
        WHERE email = email_in
        RETURNING email INTO aggiornato;
    END IF;

    IF aggiornato IS NOT NULL
    THEN
        RETURN '1';
    ELSE 
        RETURN '0';
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE PROCEDURE eventi.aggiorna_pw (
    email_in text,
    new_pw text
)
AS $$
BEGIN
    UPDATE eventi.utenti AS u
    SET pw = new_pw
    WHERE u.email = email_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di eliminazione di un evento esistente:
CREATE OR REPLACE PROCEDURE eventi.elimina_evento (
    codice_in varchar
)
AS $$
BEGIN
    DELETE FROM eventi.eventi AS e
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di verifica dell'autenticazione:
CREATE OR REPLACE FUNCTION eventi.autenticazione (
    email_in text
) 
RETURNS SETOF eventi.utenti AS $$
DECLARE
    verificato eventi.utenti%ROWTYPE;
BEGIN
    SELECT u.email
    INTO verificato
    FROM eventi.utenti AS u
    WHERE u.email = email_in;

    RETURN NEXT verificato;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento del nome di un evento:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento_nome (
    codice_in integer,
    nome_evento_in varchar
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET nome_evento = nome_evento_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della data di un evento:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento_data (
    codice_in integer,
    data_in date
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET data_evento = data_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento del luogo di un evento:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento_luogo (
    codice_in integer,
    luogo_in varchar
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET luogo = luogo_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento dell'immagine di un evento:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento_imm (
    codice_in integer,
    immagine_in bytea
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET immagine = immagine_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della descrizione di un evento:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_evento_desc (
    codice_in integer,
    descrizione_in varchar
) AS $$
BEGIN
    UPDATE eventi.eventi AS e
    SET descrizione = descrizione_in
    WHERE e.codice = codice_in;
END;
$$ LANGUAGE plpgsql;