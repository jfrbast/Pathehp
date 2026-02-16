USE cinema_reservation;

-- Utilisateurs initiaux (mots de passe déjà hashés avec password_hash)
INSERT INTO users (name, email, password, role, created_at) VALUES
('Admin', 'admin@monkeycinema.local', '$2y$10$GdziHQIaSLdSX4avZY5g1uZKzsIGohFBH3UZd1q.cdx6Q8RBdQ13e', 'admin', NOW()),
('user', 'user@monkeycinema.local', '$2y$10$oQeH1ATqfEGWDylqU0RvDuPn45Vmtn1s6i.FuITq/Yr77UDdONBBO', 'user', NOW());

-- Films sur les singes
INSERT INTO films (title, description, duration, created_at) VALUES
('La Planète des Singes', 'Les humains affrontent une civilisation de singes évolués.', 120, NOW()),
('King Kong', 'Un gigantesque gorille capturé sur une île mystérieuse.', 135, NOW()),
('Madagascar: Opération Babouins', 'Aventures déjantées avec des singes et autres animaux.', 95, NOW());

-- Séances d'exemple
INSERT INTO seances (film_id, start_time, seats_total) VALUES
(1, '2026-02-10 20:30:00', 100),
(1, '2026-02-11 18:00:00', 80),
(2, '2026-02-10 21:00:00', 120),
(3, '2026-02-12 16:00:00', 60);

