SELECT * FROM eventi.eventi;

SELECT * FROM eventi.comici;

SELECT * FROM eventi.musicisti;

SELECT * FROM eventi.aggiungi_evento_comico_musicista(1, 1, null);

SELECT * FROM eventi.aggiungi_evento_comico_musicista(1, null, 1);

SELECT * FROM eventi.eventi_comici;

SELECT * FROM eventi.eventi_musicisti;

SELECT * FROM eventi.get_artisti_evento(1);