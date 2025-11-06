CREATE DATABASE IF NOT EXISTS Vainilla
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE Vainilla

DROP TABLE IF EXISTS usuarios

CREATE TABLE usuarios (
    id  INT AUTO_INCREMENT KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    contrasena_hash VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rol VARCHAR(10) NOT NULL
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS ingredientes

CREATE TABLE ingredientes (
    id INT AUTO_INCREMENT KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


CREATE TABLE recetas (
    id INT AUTO_INCREMENT KEY,
    nombre VARCHAR(100) COLLATE utf8mb4_unicode_ci,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    imagen VARCHAR(255),
    descripcion TEXT,
    tiempo INT,
    id_usuario INT NOT NULL,
    estado ENUM ('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente',

    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE recetas_ingredientes (
    id_receta INT NOT NULL,
    id_ingrediente INT NOT NULL,
    cantidad VARCHAR(100),
    unidad VARCHAR(50),

    PRIMARY KEY (id_receta, id_ingrediente),

    FOREIGN KEY (id_receta) REFERENCES recetas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_ingrediente) REFERENCES ingredientes(id) ON DELETE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE receta_pasos (
    id INT AUTO_INCREMENT KEY,
    id_receta INT NOT NULL,
    orden INT,
    
    FOREIGN KEY (id_receta) REFERENCES recetas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;