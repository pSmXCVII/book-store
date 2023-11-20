CREATE TABLE `publishers` (
  `id` int (11) NOT NULL AUTO_INCREMENT,
  `name` varchar (100) NOT NULL,
  `description` varchar (300) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp (),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp (),
  PRIMARY KEY (`id`)
);

CREATE TABLE `books` (
  `id` int (11) NOT NULL AUTO_INCREMENT,
  `name` varchar (300) NOT NULL,
  `description` varchar (300) DEFAULT NULL,
  `publisherId` int (11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp (),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp (),
  PRIMARY KEY (`id`),
  KEY `fk_editora_acervo` (`publisherId`),
  CONSTRAINT `fk_editora_acervo` FOREIGN KEY (`publisherId`) REFERENCES `publishers` (`id`)
);

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Companhia das Letras",
    "Uma das maiores editoras do Brasil."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Record",
    "Publica diversos gêneros literários."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Intrínseca",
    "Especializada em livros de ficção."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Globo",
    "Parte do Grupo Globo e publica best-sellers."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Rocco",
    "Conhecida por lançar a série Harry Potter no Brasil."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Leya",
    "Publica autores nacionais e internacionais."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Arqueiro",
    "Especializada em romances e suspense."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora HarperCollins",
    "Parte de uma grande editora global."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Novo Século",
    "Foco em autores nacionais e literatura fantástica."
  );

INSERT INTO
  publishers (name, description)
VALUES
  (
    "Editora Zahar",
    "Especializada em edições de qualidade e cultura."
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Dom Casmurro",
    "Obra-prima de Machado de Assis.",
    1
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Cem Anos de Solidão",
    "Escrito por Gabriel García Márquez.",
    2
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Culpa é das Estrelas",
    "De John Green, emocionante e best-seller.",
    3
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "O Pequeno Príncipe",
    "Clássico de Antoine de Saint-Exupéry.",
    4
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Harry Potter e a Pedra Filosofal",
    "J.K. Rowling, início da série.",
    5
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Menina que Roubava Livros",
    "Markus Zusak, narrado pela Morte.",
    6
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "O Código Da Vinci",
    "Dan Brown, mistério e conspiração.",
    7
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Coragem de Ser Imperfeito",
    "Brené Brown, sobre vulnerabilidade.",
    8
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "O Silmarillion",
    "J.R.R. Tolkien, história da Terra-média.",
    9
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Origem das Espécies",
    "Charles Darwin, evolução da vida.",
    10
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Memórias Póstumas de Brás Cubas",
    "Machado de Assis, sátira social.",
    1
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Cemitério Maldito",
    "Stephen King, terror sobrenatural.",
    2
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Extraordinário",
    "R.J. Palacio, história de superação.",
    3
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "O Pequeno Príncipe",
    "Edição de luxo ilustrada.",
    4
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Harry Potter e o Cálice de Fogo",
    "Continuação da saga.",
    5
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Menina que Roubava Livros",
    "Edição especial.",
    6
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "Anjos e Demônios",
    "Dan Brown, thriller religioso.",
    7
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "A Coragem de Ser Imperfeito",
    "Versão de bolso.",
    8
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  (
    "O Hobbit",
    "J.R.R. Tolkien, aventuras de Bilbo.",
    9
  );

INSERT INTO
  books (name, description, publisherId)
VALUES
  ("A Origem das Espécies", "Edição comentada.", 10);