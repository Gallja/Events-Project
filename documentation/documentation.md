# Events Project - Official Documentation

## INDEX

- [Introduction](#introduction)
- [Analysis of client's requirement](#analysis-of-clients-requirement)
- [Management System](#management-system)
    - [Entity Relationship model](#entity-relationship-model)
    - [Database's structure](#databases-structure)
        - Inter-relational bond
        - Main procedures & Functions
    - Web App
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
To manage properly the entire system, databes needs 6 tables:
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