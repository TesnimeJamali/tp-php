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
-- Insert users into the users table (without hashing the passwords)
INSERT INTO users (username, email, password, role)
VALUES
    ('john_doe', 'john@example.com', 'password123', 'user'),
    ('admin_user', 'admin@example.com', 'adminpassword', 'admin'),
    ('jane_smith', 'jane@example.com', 'mypassword', 'user'),
    ('alice_walker', 'alice@example.com', 'alicepass', 'admin');
CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday DATE NOT NULL,
    image VARCHAR(255), -- Stocke le nom du fichier image
    section VARCHAR(100) NOT NULL
);
INSERT INTO etudiant (name, birthday, image, section) VALUES
('Alice Dupont', '2002-05-14', 'image.jpeg', 'Informatique'),
('Bob Martin', '2001-09-22', 'bob.png', 'Mathématiques'),
('Charlie Durand', '2003-02-10', NULL, 'Physique');
CREATE TABLE section (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designation VARCHAR(100) NOT NULL,
    description TEXT
);
INSERT INTO section (designation, description) VALUES
('Informatique', 'Étude des systèmes informatiques et du développement logiciel.'),
('Mathématiques', 'Étude des nombres, des structures et des modèles mathématiques.'),
('Physique', 'Étude des lois fondamentales de la nature.'),
('Chimie', 'Étude des substances et de leurs interactions.'),
('Biologie', 'Étude des êtres vivants et de leurs environnements.');
