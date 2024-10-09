USE bancophp;

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);


CREATE TABLE Artistas
(
	id_artista INT NOT NULL AUTO_INCREMENT,
	idade INT,
	nacionalidade VARCHAR(50),
	genero ENUM('F', 'M'),
	nome VARCHAR(30) NOT NULL,
	id_banda INT,
	PRIMARY KEY (id_artista),
	FOREIGN KEY (id_banda) REFERENCES Bandas (id_banda)
);

CREATE TABLE Bandas
(
	id_banda INT NOT NULL AUTO_INCREMENT,
	nome_banda VARCHAR(100) NOT NULL,
	data_fundacao DATE,
    	id_artista INT,
	PRIMARY KEY (id_banda),
    	FOREIGN KEY (id_artista) REFERENCES Artistas (id_artista)
    
);

CREATE TABLE Musicas
(
	id_musica INT NOT NULL AUTO_INCREMENT,
	nome_musica VARCHAR(100) NOT NULL,
    	id_banda INT,
	PRIMARY KEY (id_musica),
    	FOREIGN KEY (id_banda) REFERENCES Bandas (id_banda)
);
