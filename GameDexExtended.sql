DROP DATABASE IF EXISTS GameDexExtended;

CREATE DATABASE GameDexExtended;

USE GameDexExtended;

CREATE TABLE
    Permesso (
        id INT PRIMARY KEY AUTO_INCREMENT,
        denominazione varchar(80) NOT NULL,
        descrizione TEXT
    );

CREATE TABLE
    Team (
        id INT PRIMARY KEY AUTO_INCREMENT,
        descrizione TEXT,
        inizio DATE NOT NULL,
        fine DATE NOT NULL,
        CHECK (inizio < fine)
    );

CREATE TABLE
    Utente (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome varchar(100) NOT NULL,
        cognome varchar(100) NOT NULL,
        indirizzo varchar(400),
        esperienza TEXT NOT NULL,
        stipendio FLOAT NOT NULL,
        username varchar(80) NOT NULL UNIQUE,
        `password` varchar(255) NOT NULL,
        ultimo_accesso DATETIME NOT NULL,
        attivo BOOLEAN DEFAULT 0,
        id_permesso INT,
        FOREIGN KEY (id_permesso) REFERENCES Permesso (id)
    );

CREATE TABLE
    Partecipa (
        id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        ruolo varchar(100) NOT NULL,
        id_utente INT NOT NULL,
        id_team INT NOT NULL,
        FOREIGN KEY (id_utente) REFERENCES Utente (id),
        FOREIGN KEY (id_team) REFERENCES Team (id)
    );

CREATE TABLE
    Videogioco (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome varchar(200) NOT NULL,
        PEGI INT NOT NULL,
        stato varchar(20),
        vendite INT NOT NULL
    );

CREATE TABLE
    Sviluppa (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_videogioco INT NOT NULL,
        id_team INT NOT NULL,
        FOREIGN KEY (id_videogioco) REFERENCES Videogioco (id),
        FOREIGN KEY (id_team) REFERENCES Team (id)
    );

CREATE TABLE
    Categoria (
        id INT PRIMARY KEY AUTO_INCREMENT,
        denominazione varchar(80) NOT NULL,
        descrizione TEXT
    );

CREATE TABLE
    Collocato (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_videogioco INT NOT NULL,
        id_categoria INT NOT NULL,
        FOREIGN KEY (id_videogioco) REFERENCES Videogioco (id),
        FOREIGN KEY (id_categoria) REFERENCES Categoria (id)
    );

CREATE TABLE
    Piattaforma (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome varchar(80) NOT NULL,
        url_ws TEXT NOT NULL
    );


CREATE TABLE
    Pubblicato (
        id INT PRIMARY KEY AUTO_INCREMENT,
        costo_percentuale FLOAT NOT NULL,
        percentuale FLOAT NOT NULL,
        id_videogioco INT NOT NULL,
        id_piattaforma INT NOT NULL,
        FOREIGN KEY (id_videogioco) REFERENCES Videogioco (id),
        FOREIGN KEY (id_piattaforma) REFERENCES Piattaforma (id)
    );

CREATE TABLE
    Recensione (
        id INT PRIMARY KEY AUTO_INCREMENT,
        data DATETIME NOT NULL,
        commento TEXT NOT NULL,
        voto INT NOT NULL,
        utente varchar(200) NOT NULL,
        id_videogioco INT NOT NULL,
        id_piattaforma INT NOT NULL,
        FOREIGN KEY (id_videogioco) REFERENCES Videogioco (id),
        FOREIGN KEY (id_piattaforma) REFERENCES Piattaforma (id)
    );

-- Inserimento dati nella tabella Permesso
INSERT INTO Permesso (denominazione, descrizione) VALUES 
('Admin', 'Accesso completo al sistema'),
('Developer', 'Accesso alle funzionalità di sviluppo'),
('User', 'Accesso base per gli utenti comuni');

-- Inserimento dati nella tabella Team
INSERT INTO Team (descrizione, inizio, fine) VALUES 
('Team Alpha - Sviluppo RPG', '2023-01-01', '2024-01-01'),
('Team Beta - Sviluppo FPS', '2023-06-01', '2024-06-01'),
('Team Gamma - Supporto Tecnico', '2023-03-01', '2024-03-01');

-- Inserimento dati nella tabella Utente
INSERT INTO Utente (nome, cognome, indirizzo, esperienza, stipendio, username, `password`, ultimo_accesso, attivo, id_permesso) VALUES 
('Mario', 'Rossi', 'Via Roma, 10, Milano', '5 anni di esperienza in sviluppo', 35000, 'mario.rossi', '$2y$10$M12vXCdkSHNP1P6cioMIEupGTkdet1Ay1Odcftjjc38HxsiKHM9t6', '2024-03-10 12:30:00', 1, 1),
('Luca', 'Bianchi', 'Via Verdi, 22, Torino', '2 anni di esperienza in QA', 28000, 'luca.bianchi', '$2y$10$q4Caoo4jZulhgfb9aMfFse7qo3Uhh6b5/TZ6HjqXqa/EpsI1iPYAe', '2024-03-11 09:15:00', 1, 2),
('Giulia', 'Neri', 'Corso Italia, 5, Firenze', '3 anni di esperienza in design UI', 30000, 'giulia.neri', '$2y$10$GIaCqiHvQ/mnk2oxLvIxVOc1cN6GNI5uwsSxPnapO3bKCixn6G4IO', '2024-03-09 18:45:00', 1, 3);

-- Inserimento dati nella tabella Partecipa
INSERT INTO Partecipa (ruolo, id_utente, id_team) VALUES 
('Lead Developer', 1, 1),
('Game Tester', 2, 2),
('UI Designer', 3, 1);

-- Inserimento dati nella tabella Videogioco
INSERT INTO Videogioco (nome, PEGI, stato, vendite) VALUES 
('Legend of the Warrior', 18, 'Rilasciato', 500000),
('Cyber Battle', 16, 'In sviluppo', 200000),
('Fantasy Quest', 12, 'Rilasciato', 750000);

-- Inserimento dati nella tabella Sviluppa
INSERT INTO Sviluppa (id_videogioco, id_team) VALUES 
(1, 1),
(2, 2),
(3, 1);

-- Inserimento dati nella tabella Categoria
INSERT INTO Categoria (denominazione, descrizione) VALUES 
('RPG', 'Giochi di ruolo'),
('FPS', 'Sparatutto in prima persona'),
('Strategia', 'Giochi di strategia');

-- Inserimento dati nella tabella Collocato
INSERT INTO Collocato (id_videogioco, id_categoria) VALUES 
(1, 1),
(2, 2),
(3, 1);

-- Inserimento dati nella tabella Piattaforma
INSERT INTO Piattaforma (nome, url_ws) VALUES 
('Steam', 'https://api.steam.com'),
('PlayStation Network', 'https://api.psn.com'),
('Xbox Live', 'https://api.xboxlive.com');

-- Inserimento dati nella tabella Pubblicato
INSERT INTO Pubblicato (costo_percentuale, percentuale, id_videogioco, id_piattaforma) VALUES 
(10.5, 30, 1, 1),
(12.0, 25, 2, 2),
(15.0, 40, 3, 3);

-- Inserimento dati nella tabella Recensione
INSERT INTO Recensione (data, commento, voto, utente, id_videogioco, id_piattaforma) VALUES 
('2024-03-05 14:00:00', 'Gioco fantastico! Gameplay coinvolgente.', 9, 'MarcoGamer', 1, 1),
('2024-03-06 15:30:00', 'Buon titolo, ma con qualche bug da sistemare.', 7, 'AnnaReviewer', 2, 2),
('2024-03-07 12:45:00', 'Grafica mozzafiato, lo consiglio.', 8, 'LucaPlayer', 3, 3);
