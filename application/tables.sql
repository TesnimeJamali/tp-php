CREATE DATABASE user_management;

USE user_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday DATE NOT NULL,
    image VARCHAR(255), -- Stocke le nom du fichier image
    section VARCHAR(100) NOT NULL
);

CREATE TABLE section (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(100) NOT NULL,
    description TEXT
);

