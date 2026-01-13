-- ========================================
-- UNIVERSE
-- ========================================
CREATE TABLE IF NOT EXISTS universe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) NOT NULL,
    descr VARCHAR(255)
);

-- Insertion des univers
INSERT INTO universe (name) VALUES
('ME'),
('FO'),
('SW');

-- ========================================
-- ROLES
-- ======================================== 
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role varchar(50) NOT NULL UNIQUE
);

INSERT INTO roles (role) VALUES
('Admin'),
('MJ'),
('Chef de Groupe'),
('Joueur');


-- ========================================
-- USERS
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    universe_id INT NOT NULL,
    pseudo VARCHAR(80),
    email VARCHAR(75),
    avatar VARCHAR(255),
    role INT,
    FOREIGN KEY (role) REFERENCES roles(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insertion des utilisateurs
INSERT INTO users (username, password, universe_id, pseudo, email, role) VALUES

-- Testeurs
-- Password01!
('Test1','$argon2id$v=19$m=65536,t=3,p=4$b0lzVWI5ZGY1SzV5MGNjRQ$VFjFSvaV/fT8VkhbaSYvQrjci5qQa2d9BGG6VX94asQ', 1, 'Cahuète', 'email@email.fr', 1),

-- Password02!
('Test2','$argon2id$v=19$m=65536,t=3,p=4$amhadGhKWHNad3J6MXYwVQ$ybhJdHc7kceQ6AIa+5xMAXcW3kw4PG0jtrqOZDsZ8+Q', 2, 'Non', 'none@none.fr', 1),

-- Password03!
('Test3','$argon2id$v=19$m=65536,t=3,p=4$SzRsamhnWi80UFJSMml1cg$XKrU+VZ1gU0HhFX71zecOAbS1PDPcYnnHmi4Yvmf8jA', 3, 'Obiwan', 'jedi@council.com', 1),

-- Joueurs
-- Password04!
('Test4','$argon2id$v=19$m=65536,t=3,p=4$dEdTU01IOTdoci9CUU9VLg$UMDauZuWjW61BH29LLcuXy9uVUoMYiHvQ/DYgSjLaeI', 1, 'Shepard', 'shepard@alliance.extranet', 3),

-- Password05!
('Test5','$argon2id$v=19$m=65536,t=3,p=4$b2VzOUJRbjg3M2tnb0FmNw$v2RGwSWZ9/ATukrnXhJGzydLHNhdhB/eVAZis1xmLo4', 1, 'Tali', 'tali@rannoch.extranet', 4),

-- Password06!
('Test6','$argon2id$v=19$m=65536,t=3,p=4$Y1c2VTdFNHg4Y3RMVzd1aw$hbN9vW7KXmu8cSENYiSXd30xNefCNy8yBP28uDNafYU', 1, 'Liara', 'Liara@asari.extranet', 4),

-- Password07!
('Test7','$argon2id$v=19$m=65536,t=3,p=4$bC80eFZTL3VsNnllMHFwQQ$/51Kc9QF0+ruxhuaWWFU65zM/a4dMAEdUeDZ5ILigd8', 1, 'Garrus', 'Garrus@archangel.extranet', 4),

-- Password08!
('Test8','$argon2id$v=19$m=65536,t=3,p=4$VlNyRW9QNUdLdFBxdHNXUA$vl9op6352XsjijHl7fvn3DP9R6BbRydWD1IUPjudFYU', 2, 'Groth', 'Mar@mar.net', 3),

-- Password09!
('Test9','$argon2id$v=19$m=65536,t=3,p=4$ekVTZGJGLlFxcHJrejBHTg$fFYmdbeuPVDqLP4amVzrE3An39pqyEj2uhFs/Nxy7iY', 2, 'Manon', 'Bi@biz.net', 4),

-- Password10!
('Test10','$argon2id$v=19$m=65536,t=3,p=4$VDNjdXJNTS5LM203bmxtaQ$sta6Sr0HaSo6vxi+YQslC1OZOJTYjN492Xaewl41dq0', 2, 'Vincent', 'Garm@l.net', 4),

-- Password11!
('Test11','$argon2id$v=19$m=65536,t=3,p=4$aWdtOVJWbGIvOXN0ME9Edg$qnHiTVTbMZh4UzQkBf+gV2guhLQGwEnyX1Xy2/AQnNk', 2, 'Lily', 'luly@fo.net', 4),

-- Password12!
('Test12','$argon2id$v=19$m=65536,t=3,p=4$R1UuSnhlbi9XUVQvZWw5dw$We6ZAJ29Fj6YXAmtMJQ/ryifLHytvhDp6GxSZgQ9/Jk', 3, 'Padawan', 'padawan@jediorder.net', 3),

-- Password13!
('Test13','$argon2id$v=19$m=65536,t=3,p=4$RGEvbmRFVExORUl1cG5DWg$tYShc0fKAwwPfR/KiHZAQ+BpAlbNI0a8a/Wvfa9skc4', 3, 'Sith', 'sith@one.net', 4),

-- Password14!
('Test14','$argon2id$v=19$m=65536,t=3,p=4$Q3JZWmpSZUd5c1JCVEdGSA$Lw1wT2txISGyoI9kaPJWwcjA8p9HvUycAkCU1Ud23UI', 3, 'Master', 'master@jediorder.net', 4),

-- Password15!
('Test15','$argon2id$v=19$m=65536,t=3,p=4$am5jWko0TkJvTDlQallycQ$FN8Ho6MnECJSZJo5sWzxMHpItrImcLBhKAdMelBwTTE', 3, 'Maul', 'Maul@palpatine.net', 4),

-- MJs
-- Password16!
('MJME','$argon2id$v=19$m=65536,t=3,p=4$YXNmTDdFQlRydk1sNlpYYQ$uE9/wSKh0R+u1sMJ0shk+I1+VoNPTYVlxgzRjbL8+pA', 1, 'MJME', 'MJ@ME.me', 2),

-- Password17!
('MJFO','$argon2id$v=19$m=65536,t=3,p=4$dE1ybnpxck5JczdIWlVhdA$xGpD/pPZIcfm719LKVTQS+GrDvvaNiS0Q7cXlO/mg5E', 2, 'MJFO', 'MJ@FO.fo', 2),

-- Password18!
('MJSW','$argon2id$v=19$m=65536,t=3,p=4$bG1ZckFtWkwudjJRd1ptcg$8Gtw+PfR8zARWevGgqTR3Hf36ZLjbWG21baMEQ6Eurc', 3, 'MJSW', 'MJ@SW.sw', 2);


-- ========================================
-- CHARA
-- ========================================
CREATE TABLE IF NOT EXISTS chara (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    feuille_perso JSON NULL,
    user_id INT,
    universe_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE SET NULL ON UPDATE CASCADE
);


-- ========================================
-- PDF
-- ========================================
CREATE TABLE IF NOT EXISTS PDF (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    path VARCHAR(255) NOT NULL,
    type VARCHAR(50),
    user_id INT,
    universe_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Insertion PDF
-- Persos vierges
INSERT INTO PDF (title, path, type, user_id, universe_id) VALUES
('Feuille perso Drell', '/Common/PDF/Drell.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Asari', '/Common/PDF/Asari.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Turien', '/Common/PDF/Turien.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Turienne', '/Common/PDF/Turienne.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Krogan', '/Common/PDF/Krogan.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Galarien', '/Common/PDF/Galarien.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Quarien', '/Common/PDF/Quarien.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Quarienne', '/Common/PDF/Quarienne.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Volus', '/Common/PDF/Volus.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Humaine', '/Common/PDF/Humaine.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Humain', '/Common/PDF/Humain.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso Butarien', '/Common/PDF/Butarien.pdf', 'Feuille perso vierge', NULL, 1),
('Feuille perso générique', '/Common/PDF/Fallout - Feuille de perso V5.pdf', 'Feuille perso vierge', NULL, 2),
('Feuille perso générique', '/Common/PDF/EotE-character-sheet.pdf', 'Feuille perso vierge', NULL, 3),
('Feuille véhicule générique', '/Common/PDF/EotE-Vehicle-sheet.pdf', 'Feuille véhicule vierge', NULL, 3),
('Feuille véhicule générique', '/Common/PDF/MENE- ship-sheet.webp', 'Feuille véhicule générique', NULL, 1);
-- Règles
INSERT INTO PDF (title, path, type, user_id, universe_id) VALUES
('Règles ME', '/Common/PDF/ME - LivreDeRegles.pdf', 'Livre de règles', 16, 1),
('Règles SW', '/Common/PDF/SW - Core Rulebook.pdf', 'Livre de règles', 18, 3),
('Règles FO', '/Common/PDF/Fallout - Livre de règles.pdf', 'Livre de règles', 17, 2);
-- Persos
INSERT INTO PDF (title, path, type, user_id, universe_id) VALUES
('Feuille Gröth', '/Common/PDF/Feuille de perso Gröth.pdf', 'Perso', 8, 2),
('Feuille Lily', '/Common/PDF/Feuille de perso Lily.pdf', 'Perso', 11, 2),
('Feuille Vincent', '/Common/PDF/Feuille de perso Vincent.pdf', 'Perso', 10, 2), 
('Feuille Manon', '/Common/PDF/Feuille de perso Manon.pdf', 'Perso', 9, 2),
('Feuille Vex', '/Common/PDF/Perso - 41-Vex.pdf', 'Perso', 12, 3),
('Feuille Low', '/Common/PDF/Perso - Lowhhrick.pdf', 'Perso', 13, 3),
('Feuille Oskara', '/Common/PDF/Perso - Oskara.pdf', 'Perso', 14, 3),
('Feuille Pash', '/Common/PDF/Perso - Pash.pdf', 'Perso', 15, 3);

-- ========================================
-- CAMPAIGN
-- ========================================
CREATE TABLE IF NOT EXISTS campaign (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    descr TEXT NULL,
    status VARCHAR(50) NOT NULL,
    universe_id INT,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Univers 1 (ME - Mass Effect)
INSERT INTO campaign (name, descr, status, universe_id) VALUES
('Anomalie Oméga', 'L’équipe explore une anomalie mystérieuse près du secteur Oméga qui défie toutes les lois de la physique.', 'Terminée', 1),
('Rébellion', 'Des colons humains sont pris dans une rébellion menée par une faction inconnue, et il faut négocier ou intervenir.', 'En cours', 1),
('Projet Luminis', 'Une expérience secrète visant à créer une nouvelle forme de biotique attire l’attention des Spectres.', 'Prévue', 1);

-- Univers 2 (FO - Fallout)
INSERT INTO campaign (name, descr, status, universe_id) VALUES
('Abri 122', '(Joueurs absents)', 'Pause', 2),
('Raid Forteresse', 'Une expédition risquée pour infiltrer une base abandonnée et récupérer des ressources précieuses.', 'En cours', 2),
('Entrainement Recrues', 'Les recrues survivent aux dangers du Wasteland pour devenir de vrais survivants aguerris.', 'Prévue', 2);

-- Univers 3 (SW - Star Wars)
INSERT INTO campaign (name, descr, status, universe_id) VALUES
('Galaxie Perdue', 'Une expédition dans les confins de la galaxie.', 'Annulée', 3),
('Infiltration Coruscant', 'Une mission secrète pour infiltrer Coruscant et déjouer les plans de l’Empire.', 'En cours', 3),
('Offensive Rebelle', 'La Rébellion prépare une offensive pour libérer une planète assiégée par l’Empire.', 'Terminée', 3);

-- ========================================
-- MESSAGES (CHAT)
-- ========================================
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    universe_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- ========================================
-- MESSAGES (Notes)
-- ========================================
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    notes TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    universe_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO notes (user_id, pseudo, notes, universe_id) VALUES
(4, 'Shepard', 'Arrivée sur Eden Prime. Les balises Prothéennes ont été activées mais les Geth étaient déjà sur place.', 1),
(4, 'Shepard', 'Rencontre avec l’archéologue Liara T’Soni. Elle rejoint l’équipage du Normandy.', 1),
(4, 'Shepard', 'Conseil de la Citadelle convoqué. Spectre confirmé. Mission suivante : Feros.', 1),
(8, 'Groth', 'Exploration du centre-ville. Les Super Mutants contrôlent toujours la station de métro.', 2),
(8, 'Groth', 'Accord fragile avec la colonie de Rivet City. Manque de munitions.', 2),
(8, 'Groth', 'Groth a été grièvement blessé. Repli stratégique vers l’abri.', 2),
(12, 'Padawan', 'Arrivée sur Tatooine. Rumeurs d’un artefact Sith enfoui dans le désert.', 3),
(12, 'Padawan', 'Affrontement contre des pillards Tusken. Le Jedi a utilisé la Force pour protéger le groupe.', 3),
(12, 'Padawan', 'Vision troublante durant la méditation nocturne. Le Côté Obscur se rapproche.', 3);


-- ========================================
-- SURVEY
-- ========================================
CREATE TABLE IF NOT EXISTS poll_dates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    votes INT DEFAULT 0,
    universe_id INT,
    FOREIGN KEY (universe_id) REFERENCES universe(id) ON DELETE SET NULL ON UPDATE CASCADE
);

INSERT INTO poll_dates (description, votes, universe_id) VALUES
('Vendredi 20 septembre 2024', 0, 1),
('Samedi 21 septembre 2024', 0, 1),
('Vendredi 27 septembre 2024', 0, 1),
('Samedi 28 septembre 2024', 0, 1),
('Vendredi 28 Mars 2025', 3, 2),
('Samedi 29 Mars 2025', 1, 2),
('Dimanche 30 Mars 2025', 5, 2),
('Lundi 31 Mars 2025', 0, 2),
('Vendredi 4 Avril 2025', 0, 3),
('Samedi 5 Avril 2025', 2, 3),
('Dimanche 6 Avril 2025', 4, 3),
('Lundi 7 Avril 2025', 1, 3);