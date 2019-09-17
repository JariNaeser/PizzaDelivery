/*
	Codice SQL DataBase Progetto PizzaDelivery.

	@author JariNaeser
	@version 12.09.2019
*/

CREATE DATABASE PizzaDelivery;
USE PizzaDelivery;

CREATE TABLE TipoConsegna (
	nome VARCHAR(50) PRIMARY KEY NOT NULL
);

CREATE TABLE TipoUtente (
	nome VARCHAR(50) PRIMARY KEY NOT NULL
);

CREATE TABLE Utente(
	username VARCHAR(50) PRIMARY KEY NOT NULL,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    via VARCHAR(50) NOT NULL,
    cap int(6) NOT NULL,
    paese VARCHAR(50) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(50) NOT NULL,
    tipoUtente VARCHAR(50) NOT NULL,
    FOREIGN KEY (tipoUtente) REFERENCES TipoUtente(nome)
);

CREATE TABLE Fattorino(
	username VARCHAR(50) PRIMARY KEY NOT NULL,
	posizioneLat VARCHAR(50) NOT NULL,
    posizioneLon VARCHAR(50) NOT NULL,
    inServizio TINYINT(1) NOT NULL,
    FOREIGN KEY (username) REFERENCES Utente(username)
);

CREATE TABLE Consegna (
	id INT(6) PRIMARY KEY AUTO_INCREMENT,
    data DATETIME NOT NULL,
    tipoConsegna VARCHAR(50) NOT NULL,
    fattorino VARCHAR(50) NOT NULL,
    FOREIGN KEY (tipoConsegna) REFERENCES TipoConsegna(nome),
    FOREIGN KEY (fattorino) REFERENCES Fattorino(username)
);

CREATE TABLE Articolo (
	nome VARCHAR(50) PRIMARY KEY NOT NULL,
    descrizione VARCHAR(50) NOT NULL,
    prezzo int(6) NOT NULL,
    urlFoto VARCHAR(250) DEFAULT "DefaultImagePath"
);

CREATE TABLE Ordinazione (
	id INT(6) PRIMARY KEY AUTO_INCREMENT,
    nomeCliente VARCHAR(50) NOT NULL,
    cognomeCliente VARCHAR(50) NOT NULL,
    numeroTelefonoCliente BIGINT(20) NOT NULL,			
    via VARCHAR(50) NOT NULL,
    cap INT(6) NOT NULL,
    paese VARCHAR(50) NOT NULL,
    data DATETIME NOT NULL
);

CREATE TABLE OrdineArticolo (
	ordinazione INT(6) NOT NULL,
    articolo VARCHAR(50) NOT NULL,
	quantita INT(6) NOT NULL,
    FOREIGN KEY (ordinazione) REFERENCES Ordinazione(id),
    FOREIGN KEY (articolo) REFERENCES Articolo(nome),
    PRIMARY KEY(ordinazione, articolo)
);

/*  UTENTI  */
DROP USER 'PD_Admin'@'localhost';

CREATE USER 'PD_Admin'@'localhost' IDENTIFIED BY 'm4Ng14UnAP1774';
GRANT ALL PRIVILEGES ON PizzaDelivery.* TO 'PD_Admin'@'localhost';
FLUSH PRIVILEGES;

DROP USER 'PD_dataRetriever'@'localhost';

CREATE USER 'PD_dataRetriever'@'localhost' IDENTIFIED BY 'E$eGu1L4Qu3rY';
GRANT SELECT ON PizzaDelivery.* TO 'PD_dataRetriever'@'localhost';
FLUSH PRIVILEGES;

