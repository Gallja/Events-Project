# Events Project - Official Documentation

## INDEX

- [Introduction](#introduction)
- [Analysis of client's requirement](#analysis-of-clients-requirement)
- [Management System](#management-system)
    - [Entity Relationship model](#entity-relationship-model)
    - [Database's structure](#databases-structure)
        - [Inter-relational bond](#inter-relational-bond)
        - [Main procedures & Functions](#main-procedures--functions)
    - [Web App](#web-app)
        - Structure
        - Security & Encryption
    - API
- Frontend site

## Introduction
This repository contains all source codes of the **"Events-Project"**.  
It is developed in 2023 for _**"E-O Management"**_ company to manage and visualize all the events, comedians and musicians affiliated.

The project is divided in 2 branches:
1. **The management system** where only people with credential can log-in. It is divided in 3 fundamental parts: 
    - Relational database;
    - Web site;
    - API.  
2. **Frontend site**: public, everyone can see it. It is divided in 4 different pages.

## Analysis of client's requirement
Before to start to analize the code, the most important thing is to understand and to get an idea of client's requirement.  
First of all, it is crucial to individuate all the entity in DB and management system; after that, we want to understand how to get data to the frontend site and how to catch and visualize all of them.  
To manage properly the entire system, database needs 6 tables:
1. **UTENTI** (USERS) --> This table will contain all users that will be able to access management site.
2. **EVENTI** (EVENTS) --> This table will contain all _E-O Management_ events.
3. **COMICI** (COMEDIANS) --> This table will contain all _E-O Management_ comedians affiliated.
4. **MUSICISTI** (MUSICIANS) --> This table will contain all _E-O Management_ musicians affiliated.
5. **EVENTI_COMICI** (EVENTS_COMEDIANS) --> Association-table (link between events & comedians).
6. **EVENTI_MUSICISTI** (EVENTS_MUSICIANS) --> Association-table (link between events & musicians).

The project also needed a user-interface to manage all data in these tables: the best way was to crate a web-app with backend.  

After that, to get some data without interface directly with DB, it is important to crate an **API** (_"Application Programming Interface"_), preferably using the same language used in the **management system web app**.

Finally it is reasonable to create a web site with API's call to visualize all data we need to show to the public.

## Management System
In management system there are all components to create, modify and delete DB's entity; **database** is written in SQL language thanks to [PostgreSQL](https://www.postgresql.org/) and **web app** (and the **API**) in [PHP](https://www.php.net/) language.  

### Entity-Relationship model
After the analysis of client's requirement and before to write DB's code, it's very important to conceptualize schematically the database. To to that, this is the E.R. :

![ER-SCHEMA](/documentation/img/ER-eventi.jpg)

### Database's structure
After the completion of the Entity Relationship model, the database was created with its structure, including constraints, procedures, and functions designed to insert, modify, and display all the data related to the system.

#### Inter-relational bond
|RELATION                               |ATTRIBUTE        |TYPE   |BOND         |DOMAIN              |REFERENCE  |
|---------------------------------------|-----------------|-------|-------------|--------------------|-----------|
|**UTENTI (Users)**                     |**email**        |varchar|PRIMARY KEY  |                    |           |
|                                       |password         |varchar|NOT NULL     |password != ""      |           |
|                                       |                 |       |             |                    |           |
|**EVENTI (Events)**                    |**codice**       |serial |PRIMARY KEY  |                    |           |
|                                       |nome_evento      |varchar|NOT NULL     |nome_evento != ""   |           |
|                                       |data_evento      |date   |NOT NULL     |data_evento != ""   |           |
|                                       |ora_evento       |time   |NOT NULL     |                    |           |
|                                       |luogo            |varchar|NOT NULL     |luogo != ""         |           |
|                                       |immagine         |bytea  |NOT NULL     |                    |           |
|                                       |descrizione      |varchar|NOT NULL     |descrizione != ""   |           |
|                                       |link_biglietto   |varchar|             |                    |           |
|                                       |                 |       |             |                    |           |
|**COMEDIANS (Comici)**                 |**id**           |serial |PRIMARY KEY  |                    |           |
|                                       |nome_comico      |varchar|NOT NULL     |nome_comico != ""   |           |
|                                       |cognome_comico   |varchar|NOT NULL     |cognome_comico != ""|           |
|                                       |profilo          |bytea  |NOT NULL     |                    |           |
|                                       |bio              |varchar|NOT NULL     |bio != ""           |           |
|                                       |                 |       |             |                    |           |
|**EVENTI_COMICI (Events_Comedians)**   |**evento**       |integer|PPK, NOT NULL|                    |*EVENTI*   |
|                                       |**comico**       |integer|PPK, NOT NULL|                    |*COMICI*   |
|                                       |                 |       |             |                    |           |
|**MUSICIANS (Musicisti)**              |**id_musicista** |serial |PRIMARY KEY  |                    |           |
|                                       |nome_musicista   |varchar|NOT NULL     |nome_musicista != ""|           |
|                                       |profilo_musicista|bytea  |NOT NULL     |                    |           |
|                                       |bio_musicista    |varchar|NOT NULL     |bio_musicista != "" |           |
|                                       |                 |       |             |                    |           |
|**EVENTI_MUSICISTI (Events_Musicians)**|**evento**       |integer|PPK, NOT NULL|                    |*EVENTI*   |
|                                       |**musicista**    |integer|PPK, NOT NULL|                    |*MUSICISTI*|

#### Main procedures & functions
The database also features various procedures and functions for its operation. The main procedures involve the insertion and modification of various tables. Here are 2 examples:

```SQL
--Insert a new event:
CREATE OR REPLACE PROCEDURE eventi.insert_evento (
    nome_evento varchar,
    data_evento date,
    ora_evento time,
    luogo varchar,
    immagine bytea,
    descrizione varchar,
    link_biglietto varchar
) AS $$
BEGIN
    INSERT INTO eventi.eventi(nome_evento, data_evento, ora_evento, luogo, immagine, descrizione, link_biglietto)
    VALUES (nome_evento, data_evento, ora_evento, luogo, immagine, descrizione, link_biglietto);
END;
$$ LANGUAGE plpgsql;
```

```SQL
--Update event's name:
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
```

As for the functions, they primarily serve to retrieve one or more records from the database based on the needs of the website at a given moment. Here is an example:

```SQL
--Return details of comedians and musicians affiliated with the event:
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
```

## Web App
As mentioned earlier, the web app allows authorized users to have a web interface capable of properly managing all data related to management. In this regard, an intuitive and simple page structure must be ensured, along with appropriate protection of sensitive data to prevent attacks from malicious users.