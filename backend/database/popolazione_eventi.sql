-- Inserimento utente:
CALL eventi.insert_utente('gallia4729@gmail.com', 'ProvaPass');

-- Inserimento evento di prova:
CALL eventi.insert_evento('Evento prova', '2023-05-11', 'Casalpusterlengo', 'Evento di prova a Casalpusterlengo.');

-- Query che visualizza la data dell'evento in formato europeo:
SELECT TO_CHAR(eventi.data_evento, 'DD/MM/YYYY') AS new_data
FROM eventi.eventi;

-- Query di verifica utenti:
SELECT *
FROM eventi.utenti;

-- Query di verifica eventi:
SELECT *
FROM eventi.eventi;