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
    profilo bytea NOT NULL,
    bio varchar NOT NULL CHECK (bio <> '')
);

-- Tabella dei musicisti:
CREATE TABLE eventi.musicisti (
    id_musicista serial PRIMARY KEY,
    nome_musicista varchar NOT NULL CHECK (nome_musicista <> ''),
    profilo_musicista bytea NOT NULL,
    bio_musicista varchar NOT NULL CHECK (bio_musicista <> '')
);

-- Tabella di associazione tra eventi e comici:
CREATE TABLE eventi.eventi_comici (
    evento integer NOT NULL,
        FOREIGN KEY (evento) REFERENCES eventi.eventi ON DELETE CASCADE,
    comico integer NOT NULL,
        FOREIGN KEY (comico) REFERENCES eventi.comici ON DELETE CASCADE,
    PRIMARY KEY (evento, comico)    
);

-- Tabella di associazione tra eventi e musicisti:
CREATE TABLE eventi.eventi_musicisti (
    evento integer NOT NULL,
        FOREIGN KEY (evento) REFERENCES eventi.eventi ON DELETE CASCADE,
    musicista integer NOT NULL,
        FOREIGN KEY (musicista) REFERENCES eventi.musicisti ON DELETE CASCADE,
    PRIMARY KEY (evento, musicista)
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
    profilo bytea,
    bio varchar
) AS $$
BEGIN
    INSERT INTO eventi.comici(nome_comico, cognome_comico, profilo, bio)
    VALUES(nome_comico, cognome_comico, profilo, bio);
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

-- Funzione di modifica/aggiornamento del nome di un comico:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_comico_nome (
    id_in integer,
    nome_in varchar
) AS $$
BEGIN
    UPDATE eventi.comici AS c
    SET nome_comico = nome_in
    WHERE c.id = id_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento del cognome di un comico:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_comico_cognome (
    id_in integer,
    cognome_in varchar
) AS $$
BEGIN
    UPDATE eventi.comici AS c
    SET cognome_comico = cognome_in
    WHERE c.id = id_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della foto profilo di un comico:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_comico_foto (
    id_in integer,
    foto_in bytea
) AS $$
BEGIN
    UPDATE eventi.comici AS c
    SET profilo = foto_in
    WHERE c.id = id_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della bio di un comico:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_comico_bio (
    id_in integer,
    desc_in varchar
) AS $$
BEGIN
    UPDATE eventi.comici AS c  
    SET bio = desc_in
    WHERE c.id = id_in;
END;
$$ LANGUAGE plpgsql;

-- Procedura di inserimento di un nuovo musicista:
CREATE OR REPLACE PROCEDURE eventi.insert_musicista (
    nome_musicista varchar,
    profilo_musicista bytea,
    bio_musicista varchar
) AS $$
BEGIN
    INSERT INTO eventi.musicisti(nome_musicista, profilo_musicista, bio_musicista)
    VALUES(nome_musicista, profilo_musicista, bio_musicista);
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento del nome di un musicista:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_musicista_nome (
    id_in integer,
    nome_in varchar
) AS $$
BEGIN
    UPDATE eventi.musicisti AS m
    SET nome_musicista = nome_in
    WHERE m.id_musicista = id_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della foto profilo di un musicista:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_musicista_foto (
    id_in integer,
    foto_in bytea
) AS $$
BEGIN
    UPDATE eventi.musicisti AS m
    SET profilo_musicista = foto_in
    WHERE m.id_musicista = id_in;
END;
$$ LANGUAGE plpgsql;

-- Funzione di modifica/aggiornamento della bio di un musicista:
CREATE OR REPLACE PROCEDURE eventi.aggiorna_musicista_desc (
    id_in integer,
    desc_in varchar
) AS $$
BEGIN
    UPDATE eventi.musicisti AS m
    SET bio_musicista = desc_in
    WHERE m.id_musicista = id_in;
END;
$$ LANGUAGE plpgsql;

-- Procedura di inserimento nelle tabelle eventi_comici ed eventi_musicisti:
CREATE OR REPLACE FUNCTION eventi.inserisci_comici_musicisti (
    evento_id integer,
    comici integer[],
    musicisti integer[]
) RETURNS void AS $$
BEGIN
    -- Inserimento nella tabella eventi_comici se l'array comici non è vuoto:
    IF array_length(comici, 1) IS NOT NULL THEN
        INSERT INTO eventi.eventi_comici (evento, comico)
        SELECT evento_id, comico_id
        FROM unnest(comici) AS comico_id;
    END IF;

    -- Inserimento nella tabella eventi_musicisti se l'array musicisti non è vuoto:
    IF array_length(musicisti, 1) IS NOT NULL THEN
        INSERT INTO eventi.eventi_musicisti (evento, musicista)
        SELECT evento_id, musicista_id
        FROM unnest(musicisti) AS musicista_id;
    END IF;
END;
$$ LANGUAGE plpgsql;

-- Funzione che restituisce i dettagli del comico e del musicista affiliati ad un evento:
CREATE OR REPLACE FUNCTION eventi.get_artisti_evento (
	codice_evento integer
)
RETURNS TABLE (nome_artista varchar, cognome_artista varchar) 
AS $$
BEGIN
    RETURN QUERY
    SELECT nome_comico, cognome_comico
    FROM eventi.eventi_comici ec
    JOIN eventi.comici c ON ec.comico = c.id
    WHERE ec.evento = codice_evento

    UNION

    SELECT nome_musicista, NULL
    FROM eventi.eventi_musicisti em
    JOIN eventi.musicisti m ON em.musicista = m.id_musicista
    WHERE em.evento = codice_evento;

END;
$$ LANGUAGE plpgsql;