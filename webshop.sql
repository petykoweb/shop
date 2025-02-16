CREATE DATABASE IF NOT EXISTS bolt DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bolt;

CREATE TABLE IF NOT EXISTS felhasznalo (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nev CHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS termek (
    tkod INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    termeknev CHAR(50) NOT NULL,
    ar SMALLINT UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS kosar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    felhid INT UNSIGNED NOT NULL,
    termekkod INT UNSIGNED NOT NULL,
    mennyiseg TINYINT UNSIGNED NOT NULL DEFAULT 1,
    egysegar SMALLINT UNSIGNED NOT NULL,
    ido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (felhid) REFERENCES felhasznalo(id),
    FOREIGN KEY (termekkod) REFERENCES termek(tkod)
);

INSERT INTO termek (termeknev, ar) VALUES ('Termék 1', 1000), ('Termék 2', 1500), ('Termék 3', 2000);
ALTER TABLE termek ADD COLUMN kep_url VARCHAR(255) NULL;

INSERT INTO termek (termeknev, ar, kep_url) 
VALUES 
('Termék 1', 1000, 'https://via.placeholder.com/200'),
('Termék 2', 1500, 'https://via.placeholder.com/200'),
('Termék 3', 2000, 'https://via.placeholder.com/200');
