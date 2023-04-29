/*
 *  Studenti: Gruppo 1
 *    Classe: 5DIN
 *      A.S.: 2019/2020
 *
 * Ultima modifica: 29/05/2020
 *
 * Descrizione: File SQL di riferimento per la creazione della base di dati
 * contestuale al progetto interdisciplinare "COVID-19/Protezione Civile"
 */

DROP DATABASE IF EXISTS dbProgettoCOVID19;

CREATE DATABASE dbProgettoCOVID19
    CHARACTER SET = 'utf8'
    COLLATE = 'utf8_unicode_ci';

USE dbProgettoCOVID19;

CREATE TABLE CapoDipartimentoRegionale
(
    CodiceUnivoco     INT AUTO_INCREMENT PRIMARY KEY,
    Nome              VARCHAR(256) NOT NULL,
    Cognome           VARCHAR(256) NOT NULL,
    DataNascita       DATE         NOT NULL,
    Indirizzo         VARCHAR(256) NOT NULL,
    DataInizioMandato DATE         NOT NULL
);

CREATE TABLE Emergenza
(
    CodiceUnivoco  INT PRIMARY KEY,
    Nome           VARCHAR(256) NOT NULL,
    Gravità        VARCHAR(256) NOT NULL,
    Durata         VARCHAR(12)  NOT NULL,
    DanniMateriali INT          NOT NULL,
    NumeroFeriti   INT          NOT NULL,
    NumeroVittime  INT          NOT NULL
);

CREATE TABLE CentroPeriferico
(
    Nome             VARCHAR(256) PRIMARY KEY,
    Indirizzo        VARCHAR(256) NOT NULL,
    NumeroTelefono   VARCHAR(15)  NOT NULL,
    Regione          VARCHAR(256) NOT NULL,
    CodiceUnivocoCDR INT          NOT NULL,
    FOREIGN KEY (CodiceUnivocoCDR) REFERENCES CapoDipartimentoRegionale (CodiceUnivoco)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE EnteLocale
(
    CodiceUnivoco    CHAR(2) PRIMARY KEY,
    Nome             VARCHAR(256) NOT NULL,
    NomeSede         VARCHAR(256) NOT NULL,
    NumeroCivili     INT          NOT NULL,
    NumeroAbitanti   INT          NOT NULL,
    Specializzazione VARCHAR(256) NOT NULL,
    NomeProvincia    VARCHAR(256) NOT NULL,
    NomeCPR          VARCHAR(256) NOT NULL,
    FOREIGN KEY (NomeCPR) REFERENCES CentroPeriferico (Nome)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE UnitaOperativa
(
    SiglaProvincia             CHAR(2) PRIMARY KEY,
    RicoveratiConSintomi       INT     NOT NULL,
    RicoveratiTerapiaIntensiva INT     NOT NULL,
    TotaleOspedalizzati        INT     NOT NULL,
    IsolamentiDomiciliari      INT     NOT NULL,
    TotalePositiviAttuale      INT     NOT NULL,
    NuovoTotalePositivi        INT     NOT NULL,
    NuovoTotaleGuariti         INT     NOT NULL,
    NuovoTotaleDeceduti        INT     NOT NULL,
    NuovoTotaleCasi            INT     NOT NULL,
    NumeroTamponiEffettuati    INT     NOT NULL,
    CodiceUnivocoEnteLocale    CHAR(2) NOT NULL,
    FOREIGN KEY (CodiceUnivocoEnteLocale) REFERENCES EnteLocale (CodiceUnivoco)
        ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Gestisce
(
    CodiceUnivocoCDR       INT NOT NULL,
    CodiceUnivocoEmergenza INT NOT NULL,
    PRIMARY KEY (CodiceUnivocoCDR, CodiceUnivocoEmergenza),
    FOREIGN KEY (CodiceUnivocoCDR) REFERENCES CapoDipartimentoRegionale (CodiceUnivoco)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (CodiceUnivocoEmergenza) REFERENCES Emergenza (CodiceUnivoco)
        ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO CapoDipartimentoRegionale (Nome, Cognome, DataNascita, Indirizzo, DataInizioMandato)
    VALUE ('Mario', 'Rossi', STR_TO_DATE('14/10/1974', '%d/%m/%Y'), 'Via Rossi, 1',
           STR_TO_DATE('01/06/2019', '%d/%m/%Y'));

INSERT INTO CapoDipartimentoRegionale (Nome, Cognome, DataNascita, Indirizzo, DataInizioMandato)
    VALUE ('Luigi', 'Verdi', STR_TO_DATE('15/11/1975', '%d/%m/%Y'), 'Via Verdi, 2',
           STR_TO_DATE('02/07/2019', '%d/%m/%Y'));

INSERT INTO CapoDipartimentoRegionale (Nome, Cognome, DataNascita, Indirizzo, DataInizioMandato)
    VALUE ('Giuseppe', 'Russo', STR_TO_DATE('16/12/1976', '%d/%m/%Y'), 'Via Russo, 3',
           STR_TO_DATE('03/08/2019', '%d/%m/%Y'));

INSERT INTO CapoDipartimentoRegionale (Nome, Cognome, DataNascita, Indirizzo, DataInizioMandato)
    VALUE ('Giovanni', 'Bianconi', STR_TO_DATE('17/01/1977', '%d/%m/%Y'), 'Via Bianconi, 4',
           STR_TO_DATE('04/09/2019', '%d/%m/%Y'));

INSERT INTO Emergenza (CodiceUnivoco, Nome, Gravità, Durata, DanniMateriali, NumeroFeriti, NumeroVittime)
    VALUE (1, 'Coronavirus', 100, '2160:00' /* 3 MESI */, 231732 /* CASI TOTALI */, 47896 /* TOTALE POSITIVI */,
           33142 /* DECEDUTI */);

INSERT INTO CentroPeriferico (Nome, Indirizzo, NumeroTelefono, Regione, CodiceUnivocoCDR)
    VALUE ('CPR di Torino', 'Via Torino, 1', '0111234567', 'Piemonte', 1);

INSERT INTO CentroPeriferico (Nome, Indirizzo, NumeroTelefono, Regione, CodiceUnivocoCDR)
    VALUE ('CPR di Milano', 'Via Milano, 1', '0212345678', 'Lombardia', 2);

INSERT INTO CentroPeriferico (Nome, Indirizzo, NumeroTelefono, Regione, CodiceUnivocoCDR)
    VALUE ('CPR di Bologna', 'Via Bologna, 1', '051123456', 'Emilia-Romagna', 3);

INSERT INTO CentroPeriferico (Nome, Indirizzo, NumeroTelefono, Regione, CodiceUnivocoCDR)
    VALUE ('CPR di Venezia', 'Via Venezia, 1', '041123456', 'Veneto', 4);

/*
 * Nella definizione degli Enti locali, si utilizza il numero di abitanti della città (esclusa provincia) quale numero dei civili
 * e il numero di abitanti della città metropolitana/provincia come complesso quale valore di abitanti.
 */

INSERT INTO EnteLocale(CodiceUnivoco, Nome, NomeSede, NumeroCivili, NumeroAbitanti, Specializzazione, NomeProvincia,
                       NomeCPR)
    VALUE ('TO', 'Ente Locale di Torino', 'Sede Torino', 875698, 2282000, 'Gestione emergenze', 'Torino',
           'CPR di Torino');

INSERT INTO EnteLocale(CodiceUnivoco, Nome, NomeSede, NumeroCivili, NumeroAbitanti, Specializzazione, NomeProvincia,
                       NomeCPR)
    VALUE ('MI', 'Ente Locale di Milano', 'Sede Milano', 1378689, 3260000, 'Gestione emergenze', 'Milano',
           'CPR di Milano');

INSERT INTO EnteLocale(CodiceUnivoco, Nome, NomeSede, NumeroCivili, NumeroAbitanti, Specializzazione, NomeProvincia,
                       NomeCPR)
    VALUE ('BO', 'Ente Locale di Bologna', 'Sede Bologna', 388367, 1014619, 'Gestione emergenze', 'Bologna',
           'CPR di Bologna');

INSERT INTO EnteLocale(CodiceUnivoco, Nome, NomeSede, NumeroCivili, NumeroAbitanti, Specializzazione, NomeProvincia,
                       NomeCPR)
    VALUE ('VE', 'Ente Locale di Venezia', 'Sede Venezia', 261905, 853338, 'Gestione emergenze', 'Venezia',
           'CPR di Venezia');

INSERT INTO UnitaOperativa(SiglaProvincia, RicoveratiConSintomi, RicoveratiTerapiaIntensiva, TotaleOspedalizzati,
                           IsolamentiDomiciliari, TotalePositiviAttuale, NuovoTotalePositivi, NuovoTotaleGuariti,
                           NuovoTotaleDeceduti, NuovoTotaleCasi, NumeroTamponiEffettuati, CodiceUnivocoEnteLocale)
    VALUE ('TO', 1029, 61, 1090, 4568, 5658, 56, 2992, 3851, 30501, 309497, 'TO');

INSERT INTO UnitaOperativa(SiglaProvincia, RicoveratiConSintomi, RicoveratiTerapiaIntensiva, TotaleOspedalizzati,
                           IsolamentiDomiciliari, TotalePositiviAttuale, NuovoTotalePositivi, NuovoTotaleGuariti,
                           NuovoTotaleDeceduti, NuovoTotaleCasi, NumeroTamponiEffettuati, CodiceUnivocoEnteLocale)
    VALUE ('MI', 3552, 173, 3725, 18958, 22683, 354, 49842, 16012, 88537, 727146, 'MI');

INSERT INTO UnitaOperativa(SiglaProvincia, RicoveratiConSintomi, RicoveratiTerapiaIntensiva, TotaleOspedalizzati,
                           IsolamentiDomiciliari, TotalePositiviAttuale, NuovoTotalePositivi, NuovoTotaleGuariti,
                           NuovoTotaleDeceduti, NuovoTotaleCasi, NumeroTamponiEffettuati, CodiceUnivocoEnteLocale)
    VALUE ('BO', 429, 76, 505, 3059, 3564, 38, 2073, 4102, 27739, 316909, 'BO');

INSERT INTO UnitaOperativa(SiglaProvincia, RicoveratiConSintomi, RicoveratiTerapiaIntensiva, TotaleOspedalizzati,
                           IsolamentiDomiciliari, TotalePositiviAttuale, NuovoTotalePositivi, NuovoTotaleGuariti,
                           NuovoTotaleDeceduti, NuovoTotaleCasi, NumeroTamponiEffettuati, CodiceUnivocoEnteLocale)
    VALUE ('VE', 137, 7, 144, 1705, 1849, 9, 15379, 1906, 19134, 645049, 'VE');

INSERT INTO Gestisce(CodiceUnivocoCDR, CodiceUnivocoEmergenza)
VALUES (1, 1),
       (2, 1),
       (3, 1),
       (4, 1);