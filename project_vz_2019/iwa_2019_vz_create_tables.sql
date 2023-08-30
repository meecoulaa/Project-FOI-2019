CREATE TABLE `tip_korisnika` (
  `tip_korisnika_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`tip_korisnika_id`)
);

CREATE TABLE `korisnik` (
  `korisnik_id` INT(10) NOT NULL AUTO_INCREMENT,
  `tip_korisnika_id` INT(10) NOT NULL,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(50) NOT NULL,
  `ime` VARCHAR(100) NOT NULL,
  `prezime` VARCHAR(100) NOT NULL,
  `email` VARCHAR(50) NULL,
  `slika` TEXT NULL,
  PRIMARY KEY (`korisnik_id`),
  FOREIGN KEY (`tip_korisnika_id`) REFERENCES `tip_korisnika`(`tip_korisnika_id`)
);

CREATE TABLE `valuta` (
  `valuta_id` INT(10) NOT NULL AUTO_INCREMENT,
  `moderator_id` INT(10) NOT NULL,
  `naziv` VARCHAR(50) NOT NULL,
  `tecaj` DECIMAL NOT NULL,
  `slika` TEXT NOT NULL,
  `zvuk` TEXT NOT NULL,
  `aktivno_od` TIME NOT NULL,
  `aktivno_do` TIME NOT NULL,
  `datum_azuriranja` DATE NOT NULL,
  PRIMARY KEY (`valuta_id`),
  FOREIGN KEY (`moderator_id`) REFERENCES `korisnik`(`korisnik_id`)
);

CREATE TABLE `sredstva` (
  `korisnik_id` INT(10) NOT NULL,
  `valuta_id` INT(10) NOT NULL,
  `iznos` INT(10) NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  FOREIGN KEY (`valuta_id`) REFERENCES `valuta`(`valuta_id`)
);

CREATE TABLE `zahtjev` (
  `korisnik_id` INT(10) NOT NULL,
  `iznos` INT(10) NOT NULL,
  `prodajem_valuta_id` INT(10) NOT NULL,
  `kupujem_valuta_id` INT(10) NOT NULL,
  `datum_vrijeme_kreiranja` DATE NOT NULL,
  `prihvacen` INT(1) NOT NULL,
  PRIMARY KEY (`korisnik_id`),
  FOREIGN KEY (`prodajem_valuta_id`) REFERENCES `valuta`(`valuta_id`),
  FOREIGN KEY (`kupujem_valuta_id`) REFERENCES `valuta`(`valuta_id`)
);



