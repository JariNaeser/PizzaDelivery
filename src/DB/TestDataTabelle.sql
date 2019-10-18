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

/* CREAZIONE UTENTE */
INSERT INTO Utente VALUES (
	"jari.naeser",
	"jari", 
	"naeser", 
	"Via Mer Zarei 12", 
	6965, 
	"Svizzera",
	"jari.naeser@samtrevano.ch", 
	"test", 
	"amministratore"
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
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (1,'2019-10-16 14:04:42',NULL,'da effettuare','paolo.naeser', 49);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (2,'2019-09-18 14:06:25',NULL,'in corso','franco.fattorino', 50);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (3,'2019-10-12 14:06:25',NULL,'da effettuare','franco.fattorino', 51);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (4,'2019-03-18 14:06:25',NULL,'in corso','paolo.naeser', 68);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (7,'2018-12-18 14:07:22','2019-10-18 14:07:22','Terminata','franco.fattorino', 69);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (8,'2013-06-18 14:07:34','2019-10-18 14:07:34','Terminata','franco.fattorino', 70);
INSERT INTO `Consegna` (`id`,`dataInserimento`,`dataConsegna`,`tipoConsegna`,`fattorino`,`ordinazione`) VALUES (9,'2019-10-18 14:07:34','2019-10-18 14:07:34','Terminata','paolo.naeser', 71);


/* ARTICOLO */
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza margherita", "Molto Buona e grande", 12, "application/img/pizzaMargherita.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza ai funghi", "Buona", 13.50, "application/img/pizzaFunghi.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza prosciutto", "Molto Buona", 14, "application/img/pizzaProsciutto.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Calzone", "Molto Buona", 15, "application/img/calzone.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza alla marinara", "Molto Buona", 10, "application/img/pizzaMarinara.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Pizza quattro formaggi", "Molto Buona", 14, "application/img/pizzaFormaggi.jpg");
INSERT INTO Articolo(nome, descrizione, prezzo, urlFoto) VALUES ("Focaccia", "Molto Buona",6, "application/img/focaccia.jpg");

/* ORDINAZIONE */
INSERT INTO Ordinazione(nomeCliente, cognomeCliente, numeroTelefonoCliente, via, cap, paese, data) VALUES (
	"Paolo", "Naeser", 0041791223344, "Via Marzo 12", 6900, "Svizzera", now()
);

/* ORDINE ARTICOLO */
INSERT INTO OrdineArticolo VALUES (
	1, 2, 3
);







/* ALTER TABLE Articolo ALTER urlFoto SET DEFAULT "application/img/defaultPizza.png"; */