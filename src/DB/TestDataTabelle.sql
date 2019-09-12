/*
	Dati di Test per le tabelle del DB PizzaDelivery.

	@author JariNaeser
	@version 12.09.2019
*/

/* Opzioni: da effettuare, in corso, terminate */
INSERT INTO TipoConsegna VALUES ("da effettuare");
INSERT INTO TipoConsegna VALUES ("in corso");
INSERT INTO TipoConsegna VALUES ("terminata");

/* Opzioni: amministratore, impiegato vendita, fattorino */
INSERT INTO TipoUtente VALUES ("amministratore");
INSERT INTO TipoUtente VALUES ("impiegato vendita");
INSERT INTO TipoUtente VALUES ("fattorino");

/* UTENTE */
INSERT INTO Utente VALUES (
"jari.naeser", "jari", "naeser", 
"Via Mer Zarei 12", 6965, "Svizzera",
"jari.naeser@samtrevano.ch", "test", "amministratore"
);

INSERT INTO Utente VALUES (
"paolo.naeser", "paolo", "naeser", 
"Via Mer Zarei 12", 6965, "Svizzera",
"paolo.naeser@samtrevano.ch", "test", "fattorino"
);

/* FATTORINO */
INSERT INTO Fattorino VALUES (
	"paolo.naeser", "2.00000000", "34.0203929", true
);

/* CONSEGNA */
INSERT INTO Consegna(data, tipoConsegna, fattorino) VALUES (
	now(), "da effettuare", "paolo.naeser"
);

/* ARTICOLO */
INSERT INTO Articolo VALUES (
	"Pizza Margherita", "Con sale", 12, "./img/pm.png"
);

INSERT INTO Articolo(nome, descrizione, prezzo) VALUES (
	"Pizza ai funghi", "Con sale", 12
);

/* ORDINAZIONE */
INSERT INTO Ordinazione(nomeCliente, cognomeCliente, numeroTelefonoCliente, via, cap, paese, data) VALUES (
	"Paolo", "Naeser", 0041791223344, "Via Marzo 12", 6900, "Svizzera", now()
);

/* ORDINE ARTICOLO */
INSERT INTO OrdineArticolo VALUES (
	1, "Pizza ai funghi", 3
);