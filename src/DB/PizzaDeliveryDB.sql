/* Codice SQL DataBase Progetto PizzaDelivery */

CREATE DATABASE PizzaDelivery;
USE PizzaDelivery;

CREATE TABLE TipoConsegna (
	nome VARCHAR(20) PRIMARY KEY NOT NULL
);

CREATE TABLE TipoUtente (
	nome VARCHAR(20) PRIMARY KEY NOT NULL
);

CREATE TABLE Utente(
	username VARCHAR(50) PRIMARY KEY NOT NULL,
    nome VARCHAR(30) NOT NULL,
    cognome VARCHAR(20) NOT NULL,
    via VARCHAR(20) NOT NULL,
    cap VARCHAR(20) NOT NULL,
    paese VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    tipoUtente VARCHAR(20) NOT NULL,
    FOREIGN KEY (tipoUtente) REFERENCES TipoUtente(nome)
);

CREATE TABLE Fattorino(
	username VARCHAR(50) PRIMARY KEY NOT NULL,
	posizioneLat VARCHAR(30) NOT NULL,
    posizioneLon VARCHAR(30) NOT NULL,
    inServizio BOOL NOT NULL,
    FOREIGN KEY (username) REFERENCES Utente(username)
);

CREATE TABLE Consegna (
	id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    data DATETIME NOT NULL,
    tipoConsegna VARCHAR(20) NOT NULL,
    FOREIGN KEY (tipoConsegna) REFERENCES TipoConsegna(nome)
);

CREATE TABLE Articolo (
	nome VARCHAR(30) PRIMARY KEY NOT NULL,
    descrizione VARCHAR(30) NOT NULL,
    prezzo int(6) NOT NULL,
    urlFoto VARCHAR(50)
);

CREATE TABLE Ordinazione (
	/* TO DO */
);

CREATE TABLE OrdineAtricolo (
	/* TO DO */
);