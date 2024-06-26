-- Création de la base de données
DROP DATABASE IF EXISTS gestion_projets;
CREATE DATABASE gestion_projets;
USE gestion_projets;

-- Configuration du mode SQL pour MySQL
SET SESSION sql_mode = 'STRICT_TRANS_TABLES';

-- Table Utilisateur
-- Table Utilisateur
-- Table Utilisateur
CREATE TABLE Utilisateur (
   id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL UNIQUE,
   mot_de_passe VARCHAR(255) NOT NULL,
   photo_profil VARCHAR(255) DEFAULT NULL,
   role ENUM('developpeur', 'chef_de_projet', 'responsable_equipe') NOT NULL,
   PRIMARY KEY(id_utilisateur)
);



-- Table Projet
CREATE TABLE Projet (
   id_projet INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   date_de_debut DATE NOT NULL,
   date_fin_prevu DATE NOT NULL,
   budget DECIMAL(10, 2) NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_projet),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Table Tâche
CREATE TABLE Tache (
   id_tache INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description TEXT NOT NULL,
   date_debut DATE NOT NULL,
   date_fin DATE NOT NULL,
   statut VARCHAR(50),
   id_projet INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_tache),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_projet) REFERENCES Projet(id_projet)
);

-- Table Équipe
CREATE TABLE Equipe (
   id_equipe INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   id_projet INT NOT NULL,
   PRIMARY KEY(id_equipe),
   FOREIGN KEY(id_projet) REFERENCES Projet(id_projet)
);

-- Table Commentaire
CREATE TABLE Commentaire (
   id_commentaire INT AUTO_INCREMENT,
   contenu TEXT NOT NULL,
   date_commentaire TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_commentaire),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Table Document
CREATE TABLE Document (
   id_document INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   chemin_acces VARCHAR(255) NOT NULL,
   date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id_document)
);

-- Table Commentaire_Projet
CREATE TABLE Commentaire_Projet (
   id_projet INT,
   id_commentaire INT,
   PRIMARY KEY(id_projet, id_commentaire),
   FOREIGN KEY(id_projet) REFERENCES Projet(id_projet),
   FOREIGN KEY(id_commentaire) REFERENCES Commentaire(id_commentaire)
);

-- Table Commentaire_Tache
CREATE TABLE Commentaire_Tache (
   id_tache INT,
   id_commentaire INT,
   PRIMARY KEY(id_tache, id_commentaire),
   FOREIGN KEY(id_tache) REFERENCES Tache(id_tache),
   FOREIGN KEY(id_commentaire) REFERENCES Commentaire(id_commentaire)
);

-- Table Document_Projet
CREATE TABLE Document_Projet (
   id_projet INT,
   id_document INT,
   PRIMARY KEY(id_projet, id_document),
   FOREIGN KEY(id_projet) REFERENCES Projet(id_projet),
   FOREIGN KEY(id_document) REFERENCES Document(id_document)
);

-- Table Membre
CREATE TABLE Membre (
   id_utilisateur INT,
   id_equipe INT,
   PRIMARY KEY(id_utilisateur, id_equipe),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_equipe) REFERENCES Equipe(id_equipe)
);

-- Table Document_Tache
CREATE TABLE Document_Tache (
   id_tache INT,
   id_document INT,
   PRIMARY KEY(id_tache, id_document),
   FOREIGN KEY(id_tache) REFERENCES Tache(id_tache),
   FOREIGN KEY(id_document) REFERENCES Document(id_document)
);

-- Tables héritées de Utilisateur

-- Table Developpeur
CREATE TABLE Developpeur (
   id_dev INT AUTO_INCREMENT,
   id_utilisateur INT NOT NULL,
   specialite VARCHAR(50),
   langages_maitrises VARCHAR(255),
   PRIMARY KEY(id_dev),
   UNIQUE(id_utilisateur),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Table Chef_de_Projet
CREATE TABLE Chef_de_Projet (
   id_chef INT AUTO_INCREMENT,
   id_utilisateur INT NOT NULL,
   projets_diriges VARCHAR(255),
   niveau_experience VARCHAR(50),
   PRIMARY KEY(id_chef),
   UNIQUE(id_utilisateur),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Table Responsable_Equipe
CREATE TABLE Responsable_Equipe (
   id_responsable INT AUTO_INCREMENT,
   id_utilisateur INT NOT NULL,
   date_nomination DATE,
   liste_projets_responsables VARCHAR(255),
   PRIMARY KEY(id_responsable),
   UNIQUE(id_utilisateur),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

-- Table Budget
CREATE TABLE Budget (
   id_budget INT AUTO_INCREMENT,
   montant DECIMAL(10, 2),
   date_allocation DATE,
   etat VARCHAR(50),
   id_responsable INT NOT NULL,
   id_projet INT NOT NULL,
   PRIMARY KEY(id_budget),
   FOREIGN KEY(id_responsable) REFERENCES Responsable_Equipe(id_responsable),
   FOREIGN KEY(id_projet) REFERENCES Projet(id_projet)
);

-- Insertion de quelques utilisateurs
INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, role) VALUES 
('ronaldo', 'cristiano', 'cristiano@ronaldo.com', 'CR7', 'developpeur'),
('Doe', 'John', 'john@doe.com', 'DOE', 'developpeur'),
('messi', 'lionnel', 'lionnel@messi.com', 'LM10', 'chef_de_projet'),
('Neymar', 'Jr', 'neymar@jr.com', 'NE10', 'developpeur'),
('Mbappe', 'Kylian', 'kylian@mbappe.com', 'KM7', 'developpeur'),
('Debruyne', 'Kevin', 'kevin@debruyne.com', 'KD17', 'developpeur'),
('Salah', 'Mohamed', 'mohamed@salah.com', 'MS11', 'developpeur'),
('Hazard', 'Eden', 'eden@hazard.com', 'EH7', 'chef_de_projet'),
('Pogba', 'Paul', 'paul@pogba.com', 'PP6', 'chef_de_projet'),
('Ramos', 'Sergio', 'sergio@ramos.com', 'SR4', 'responsable_equipe');



-- Associer des utilisateurs à des rôles
INSERT INTO Developpeur (id_utilisateur, specialite, langages_maitrises) VALUES 
(1, 'Frontend', 'HTML, CSS, JavaScript'),
(2, 'Backend', 'PHP, MySQL'),
(4, 'Full Stack', 'React, Node.js'),
(5, 'Frontend', 'Vue.js, CSS'),
(6, 'Backend', 'Java, Spring Boot'),
(7, 'Full Stack', 'Angular, Firebase');

INSERT INTO Chef_de_Projet (id_utilisateur, projets_diriges, niveau_experience) VALUES 
(3, 'Projet A, Projet B', 'Expert'),
(8, 'Projet C, Projet D', 'Intermédiaire'),
(9, 'Projet E, Projet F', 'Senior');

INSERT INTO Responsable_Equipe (id_utilisateur, date_nomination, liste_projets_responsables) VALUES 
(1, '2024-01-01', 'Projet A'),
(2, '2024-01-15', 'Projet B'),
(10, '2024-02-01', 'Projet C');

-- Insertion de quelques projets
INSERT INTO Projet (titre, description, date_de_debut, date_fin_prevu, budget, id_utilisateur) VALUES 
('Projet A', 'je sais pas quoi encore projet A', '2024-06-01', '2024-12-31', 10000.00, 1),
('Projet B', 'je sais pas quoi encore projet B', '2024-07-01', '2025-01-31', 15000.00, 2),
('Projet C', 'je sais pas quoi encore projet C', '2024-08-01', '2025-02-28', 20000.00, 3);

-- Insertion de quelques tâches
INSERT INTO Tache (titre, description, date_debut, date_fin, statut, id_projet, id_utilisateur) VALUES 
('Tâche 1', 'je sais pas quoi encore 1', '2024-06-01', '2024-06-15', 'En cours', 1, 1),
('Tâche 2', 'je sais pas quoi encore 2', '2024-06-16', '2024-06-30', 'Non commencé', 1, 2),
('Tâche 3', 'je sais pas quoi encore 3', '2024-07-01', '2024-07-15', 'En cours', 2, 4),
('Tâche 4', 'je sais pas quoi encore 4', '2024-07-16', '2024-07-31', 'Non commencé', 2, 5);

-- Insertion de quelques équipes
INSERT INTO Equipe (nom, id_projet) VALUES 
('Équipe Alpha', 1),
('Équipe Beta', 2),
('Équipe Gamma', 3);

-- Insertion de membres d'équipes
INSERT INTO Membre (id_utilisateur, id_equipe) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3);

-- Insertion de quelques commentaires
INSERT INTO Commentaire (contenu, id_utilisateur) VALUES 
('Premier commentaire sur le projet A', 1),
('Deuxième commentaire sur le projet A', 2),
('Premier commentaire sur le projet B', 3),
('Premier commentaire sur le projet C', 4);

-- Insertion de quelques documents
INSERT INTO Document (nom, chemin_acces) VALUES 
('Document1.pdf', 'ph.pdf'),
('Document2.pdf', 'ph2.pdf');

-- Lier des commentaires aux projets
INSERT INTO Commentaire_Projet (id_projet, id_commentaire) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

-- Lier des commentaires aux tâches
INSERT INTO Commentaire_Tache (id_tache, id_commentaire) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- Lier des documents aux projets
INSERT INTO Document_Projet (id_projet, id_document) VALUES
(1, 1),
(2, 2);

-- Lier des documents aux tâches
INSERT INTO Document_Tache (id_tache, id_document) VALUES
(1, 1),
(2, 2);



