CREATE DATABASE IF NOT EXISTS lobs CHARACTER SET utf8 COLLATE utf8_general_ci;
USE lobs;

CREATE TABLE IF NOT EXISTS vijesti (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    datum      VARCHAR(20),
    naslov     VARCHAR(255),
    sazetak    TEXT,
    tekst      TEXT,
    slika      VARCHAR(255),
    kategorija VARCHAR(50),
    arhiva     TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS korisnik (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    ime            VARCHAR(100),
    prezime        VARCHAR(100),
    korisnicko_ime VARCHAR(100) UNIQUE,
    lozinka        VARCHAR(255),
    razina         TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES
('16.05.2019.', 'A Nancy, un horizon immobilier radieux',
 'Le marché nancéien se porte toujours aussi bien.',
 'Le marché nancéien est favorable. Les taux bancaires ne remontent pas.',
 'nancy.jpg', 'Immobilier', 0),
('16.05.2019.', 'Dans la Meuse et les Vosges, la grisaille immobilière',
 'Le marché immobilier dans ces deux départements souffre.',
 'La Meuse et les Vosges peinent à attirer de nouveaux habitants.',
 'immobilier2.jpg', 'Immobilier', 0),
('16.05.2019.', 'Haut-Rhin : entre Colmar et Mulhouse, les hauts et les bas',
 'Le marché immobilier du Haut-Rhin présente des visages très différents.',
 'À Colmar, les prix restent élevés. À Mulhouse, le marché est plus accessible.',
 'immobilier1.jpg', 'Immobilier', 0),
('16.05.2019.', 'L\'Europe, proie des vampires du populisme',
 'Le populisme gagne du terrain en Europe.',
 'De la Hongrie à l\'Italie, les partis populistes progressent dans les urnes.',
 'politique3.jpg', 'Politique', 0),
('16.05.2019.', 'En Autriche, une extrême droite banalisée',
 'En Autriche, le parti FPÖ est devenu incontournable.',
 'Le FPÖ participe aux gouvernements de coalition depuis plusieurs années.',
 'politique2.jpg', 'Politique', 0),
('16.05.2019.', 'La culture chrétienne : les valeurs que la Hongrie veut protéger',
 'Viktor Orbán défend un modèle conservateur et souverainiste.',
 'Orbán a réaffirmé les valeurs fondamentales de sa politique lors d\'un discours.',
 'politique1.jpg', 'Politique', 0);

INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES
('Admin', 'Admin', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
