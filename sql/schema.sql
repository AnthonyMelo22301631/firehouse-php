CREATE DATABASE firehouse CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE firehouse;

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE eventos (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  local VARCHAR(100) NOT NULL,
  servicos VARCHAR(255) DEFAULT NULL,
  tipo VARCHAR(50) NOT NULL,
  data_evento DATETIME NOT NULL,
  descricao TEXT DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT eventos_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE comentarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  evento_id INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  conteudo TEXT NOT NULL,
  criado_em TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id),
  KEY evento_id (evento_id),
  KEY user_id (user_id),
  CONSTRAINT comentarios_ibfk_1 FOREIGN KEY (evento_id) REFERENCES eventos (id) ON DELETE CASCADE,
  CONSTRAINT comentarios_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
