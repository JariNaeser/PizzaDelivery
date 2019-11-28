/*
	Dati di Test per le tabelle del DB PizzaDelivery.

	@author JariNaeser
	@version 12.09.2019
*/

USE PizzaDelivery;

/* Opzioni: da effettuare, in corso, terminate */
INSERT INTO TipoConsegna VALUES ("da effettuare");
INSERT INTO TipoConsegna VALUES ("in corso");
INSERT INTO TipoConsegna VALUES ("terminata");

/* Opzioni: amministratore, impiegato vendita, fattorino */
INSERT INTO TipoUtente VALUES ("amministratore");
INSERT INTO TipoUtente VALUES ("impiegato vendita");
INSERT INTO TipoUtente VALUES ("fattorino");

/* CREAZIONE UTENTE */
INSERT INTO Utente VALUES (
	"jari.naeser",
	"jari",
	"naeser",
	"Via Mer Zarei 12",
	6965,
	"Svizzera",
	"jari.naeser@samtrevano.ch",
	"9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08",
	"amministratore",
    1
);

INSERT INTO Utente VALUES (
    "franco.gialli",
    "Franco",
    "Gialli",
    "Via Scuole 12",
    6900,
    "Svizzera",
    "franco.gialli@pizzadelivery.ch",
    "9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08",
    "impiegato vendita",
    1
);

INSERT INTO Utente VALUES (
    "franco.neri",
    "Franco",
    "Neri",
    "Via Mare 4",
    6900,
    "Svizzera",
    "franco.neri@pizzadelivery.ch",
    "9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08",
    "fattorino",
    1
);

/* ARTICOLO */
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza margherita", "Molto Buona e grande", 12, "application/img/pizzaMargherita.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza ai funghi", "Buona", 13.50, "application/img/pizzaFunghi.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza prosciutto", "Molto Buona", 14, "application/img/pizzaProsciutto.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Calzone", "Molto Buona", 15, "application/img/calzone.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza alla marinara", "Molto Buona", 10, "application/img/pizzaMarinara.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza quattro formaggi", "Molto Buona", 14, "application/img/pizzaFormaggi.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Focaccia", "Molto Buona",6, "application/img/focaccia.jpg");

