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
        - [Structure](#structure)
        - [Security & Encryption](#security--encryption)
    - [API](#api)
- [Frontend site](#frontend-site)

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

To view the complete SQL code of the database, [click here](../backend/database/eventi.sql)

## Web App
As mentioned earlier, the web app allows authorized users to have a web interface capable of properly managing all data related to management. In this regard, an intuitive and simple page structure must be ensured, along with appropriate protection of sensitive data to prevent attacks from malicious users.  
To make the application responsive and suitable for viewing on smartphones or tablets, the [Bootstrap framework](https://getbootstrap.com/) has been used.

### Structure
As the first page the user sees, there is a login screen where they must enter the appropriate credentials (including email and password). Only authorized users can access the next screen.

![LOGIN PAGE](/documentation/img/login_page.png)

Once logged into the system, the screen presented to the user consists of a navigation bar, allowing them to move through all the pages that make up the application. In addition to this, there are specific input fields for entering a new event. At the bottom of the page, there is a table displaying upcoming events already stored in the database (past events can be viewed from the 'event archive' page). From this table, users can click on specific buttons to edit or delete the desired event.

![HOMEPAGE](/documentation/img/home_page_backend.png)

![TABLE](/documentation/img/table.png)

All pages of the web application, including those related to comedians and musicians, have the same structure.  
The only exception is the password change page, which features only a few input fields and a button to successfully update the password.

![CHANGE PW PAGE](/documentation/img/change_pw_page.png)


### Security & Encryption
To ensure data protection and prevent malicious access, the system is equipped with specific tools capable of addressing these issues.  
As a first step, it is necessary to make the input fields of the login screen "invulnerable" to attacks such as **SQL injection**; for this reason, they have been properly sanitized with PHP's method *pg_escape_string(sql_connection, string)*:

```PHP
$email = pg_escape_string($connection, $_POST['email']);

$sql = "SELECT * FROM eventi.autenticazione($1)";
$res = pg_prepare($connection, "get_all_esito_attesa_acc", $sql);

$res = pg_execute($connection, "get_all_esito_attesa_acc", array($email));
```

As for the security of sensitive data, such as user passwords in the system, a dedicated string encryption system has been employed on the backend: [*password_hash()* method and *PASSWORD_DEFAULT*](https://www.php.net/manual/en/function.password-hash.php).

```PHP
$pw_enc = password_hash($pw, PASSWORD_DEFAULT);

$query = "CALL eventi.insert_utente($1, $2)";
$res = pg_prepare($connection, "esito", $query);
$res = pg_execute($connection, "esito", array($email, $pw_enc));
```

All source codes of the web application are available for consultation by [clicking here](/backend/web%20app/)

## API
To supply the web application on the frontend side of the project with the necessary data to display to the public, an [**API** (*Application Programming Interface*)](https://it.wikipedia.org/wiki/Application_programming_interface) fulfills this need. Also written in PHP, the API provides all the data related to all the shows, comedians, and musicians. Additionally, it can return details of a single show (in case a user wants to learn more about a specific show and potentially go to the website to purchase the respective ticket).  
The data is provided in [**JSON** (*JavaScript Object Notation*)](https://www.json.org/json-en.html) format like this:

![JSON DATA](/documentation/img/json_datas.png)

The source code of the API can be viewed by [clicking here](/backend/API_events.php)

## Frontend Site
The final part concerns the development of the web application open to the public, where users interested in **_E-O Management_** events can view them.  
The pages, all following the same pattern, have been created using [**HTML**](https://developer.mozilla.org/en-US/docs/Web/HTML), [**CSS**](https://developer.mozilla.org/en-US/docs/Web/CSS), and [**JavaScript**](https://developer.mozilla.org/en-US/docs/Web/JavaScript). The latter, in particular, enabled the connection to the API endpoint to output all the necessary information to the page.  

The homepage looks like this:

![HOMEPAGE FRONTEND](/documentation/img/home_page_frontend.png)

The structure consists of a navbar, a section dedicated to the description of **_E-O Management_**, upcoming shows, and finally a footer.  

An example of a function written in **JavaScript** to dynamically retrieve data from the database is this:

```Javascript
function displayEventi(eventi) {
    const eventiContainer = document.getElementById('contEventi');
    eventiContainer.innerHTML = `
        <h1 class="Heading-1 centerTitle">Prossimamente:</h1>
    `;
    eventi.forEach(evento => {
        const eventoDiv = document.createElement('div');
        eventoDiv.setAttribute('class', 'home-full-width-banner section container');
        const nomeMaiusc = evento.nome_evento.toUpperCase();
        eventoDiv.innerHTML = `
            <div class="home-left1" id="third">
                <div class="home-content">
                    <span class="home-text29">${nomeMaiusc}</span>
                    <span class="home-text30">${evento.descrizione}</span>
                </div>
                <div class="home-btn button border" onclick=mostraDett(${evento.codice})>
                    <span class="home-text31">Mostra dettagli</span>
                </div>
            </div>
            <img src="data:image/jpg;base64,${evento.immagine}" class="home-image6">
        `;
        eventiContainer.appendChild(eventoDiv);
    });
}
```

To view only **JavaScript** codes of the frontend web application, [click here](/frontend/js/)  
To view the entire source code of the frontend web application, [click here](/frontend/)