`-- Table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'teacher', 'admin') NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    specialization VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (email, password, role, name, phone, specialization) 
VALUES 
    ('etudiant1@example.com', 'password123', 'student', 'Etudiant 1', '0612345678', NULL),
    ('etudiant2@example.com', 'password123', 'student', 'Etudiant 2', '0698765432', NULL),
    ('enseignant1@example.com', 'password123', 'teacher', 'Enseignant 1', '0555443322', 'Informatique'),
    ('admin@example.com', 'password123', 'admin', 'Administrateur', '0543210987', NULL);

-- Table projects
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    keywords VARCHAR(255),
    technologies VARCHAR(255),
    status ENUM('open', 'in_progress', 'closed') DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

INSERT INTO projects (teacher_id, title, description, keywords, technologies, status) 
VALUES 
    (3, 'Projet 1', 'Description du projet 1', 'IA, Machine Learning', 'Python, TensorFlow', 'open'),
    (3, 'Projet 2', 'Description du projet 2', 'Web, Django', 'Python, HTML, CSS', 'open');

-- Table applications
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    project_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

INSERT INTO applications (student_id, project_id, status) 
VALUES 
    (1, 1, 'pending'),
    (2, 1, 'pending'),
    (1, 2, 'accepted');

-- Table messages
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

INSERT INTO messages (sender_id, receiver_id, content, is_read) 
VALUES 
    (1, 3, 'Bonjour, je souhaite plus d\informations sur le Projet 1.', FALSE),
    (3, 1, 'Bien sûr, voici les détails du Projet 1.', TRUE);

-- Table groups
CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO groups (name) 
VALUES 
    ('Groupe 1'),
    ('Groupe 2');

-- Table group_members
CREATE TABLE group_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

INSERT INTO group_members (group_id, student_id) 
VALUES 
    (1, 1),
    (1, 2);

-- Table notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO notifications (user_id, message, is_read) 
VALUES 
    (1, 'Votre candidature au Projet 1 a été acceptée.', FALSE),
    (2, 'Votre candidature au Projet 1 est en attente.', FALSE);
