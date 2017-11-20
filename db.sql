DROP SCHEMA IF EXISTS booksdb;
CREATE SCHEMA booksdb;
USE booksdb;

DROP TABLE IF EXISTS books;

CREATE TABLE books (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `isbn` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES books WRITE;

INSERT INTO books (`id`, `title`, `author`, `isbn`)
VALUES
	(1,'PHP 7.0','John Smith','123-45-6789-000-1'),
	(2,'Web Services','Lynne Blair','123-45-6789-000-2'),
	(3,'Cooking Book','Ramsey Gordon','123-45-6789-000-3'),
	(4,'Software Engineering','Ian Sommerville','123-45-6789-000-4'),
	(5,'Software Engineering','Roger Pressman','123-45-6789-000-5');

UNLOCK TABLES;
