CREATE TABLE IF NOT EXISTS `Music` (
	`Id_music` integer primary key NOT NULL UNIQUE,
	`Nom_music` TEXT NOT NULL,
	`Album` TEXT NOT NULL,
	`Artiste` TEXT NOT NULL,
	`Prix` TEXT NOT NULL,
	`Style` TEXT NOT NULL,
	`Description` TEXT NOT NULL,
FOREIGN KEY(`Album`) REFERENCES `Album`(`Nom_album`),
FOREIGN KEY(`Artiste`) REFERENCES `Artiste`(`Nom_artiste`)
);
CREATE TABLE IF NOT EXISTS `Artiste` (
	`Id_artiste` integer primary key NOT NULL UNIQUE,
	`Nom_artiste` TEXT NOT NULL,
FOREIGN KEY(`Nom_artiste`) REFERENCES `Album`(`Artiste`)
);
CREATE TABLE IF NOT EXISTS `Album` (
	`Id_album` integer primary key NOT NULL UNIQUE,
	`Nom_album` TEXT NOT NULL,
	`Artiste` TEXT NOT NULL,
	`Date_sortie` REAL NOT NULL,
	`Description` TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS `Users` (
	`Id_users` integer primary key NOT NULL UNIQUE,
	`Nom_users` TEXT NOT NULL,
	`Password` TEXT NOT NULL,
	`Perm` TEXT NOT NULL
);