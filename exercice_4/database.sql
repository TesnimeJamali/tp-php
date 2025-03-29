CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL
);
INSERT INTO student (name, birth_date) VALUES 
('Samy Dupré', '2005-01-01'),
('Amélie Dupré', '2006-02-15'),
('Bruno Lecoq', '2005-03-10');

SELECT * FROM student;
