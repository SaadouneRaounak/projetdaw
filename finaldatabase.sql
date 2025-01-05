
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('teacher','student') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `phone` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
   `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `phone`, `specialization`, `profile_picture`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'adminadmin', '', 'active', NULL, NULL, NULL, '2024-12-31 14:53:23'),
(6, 'ens', 'ens1@gmail.com', '$2y$10$HA2xxGYSdY1WCfegBwgCV.q.DuOO6IwwMP6qsRcV3cpgRHmrcmNZa', 'teacher', 'active', '0561579143', '', 'uploads/manager.png', '2024-12-30 23:03:52'),
(7, 'bourekha amani amani', 'loca@gmail.com', '$2y$10$ycMVsLPb8l.jU.lVEeYMSONNvmb/QM9Pwl008Qiqkq9LLop46DQ4C', 'student', 'active', '0561579143', 'sd', 'uploads/pexels-goumbik-669619.jpg', '2024-12-31 01:52:42'),
(13, 'active', 'active@gmail.com', '$2y$10$g6leeRQAMI8FHrrHPkRY0.acRh2MX/L9SmJjEUDL6XI8FYVTV9jRe', 'teacher', 'active', '0561579143', 'active', '', '2024-12-31 23:31:11'),
(15, 'diactive', 'diactive@gmail.com', '$2y$10$n3UZwKdMeJTTbsGo2Esr4ezQfli/kFXr4q0wB.S7Z.MWiWHUfpHAS', 'teacher', 'active', '0561579143', 'diactive', '', '2024-12-31 23:34:05'),
(18, 'koukou', 'koukou@gmail.com', '$2y$10$RxRrmz1MUm23W3kXTsgr8usRMKOM1Rwsu.q0gip3YJ7HG9KGdYsKO', 'student', 'active', '0561579143', 'koukou', '', '2024-12-31 23:37:35');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `project_id` int NOT NULL,
  `group_id` int DEFAULT NULL,
  `application_status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `project_id` (`project_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `applications`
--

INSERT INTO `applications` (`id`, `student_id`, `project_id`, `group_id`, `application_status`, `submitted_at`) VALUES
(1, 1, 1, NULL, 'Pending', '2024-12-30 11:31:48'),
(2, 1, 1, NULL, 'Pending', '2024-12-30 11:31:49'),
(3, 1, 1, NULL, 'Pending', '2024-12-30 13:57:10');
DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `keywords` text,
  `technologies` text,
  `status` enum('open','in progress','closed') DEFAULT 'open',
  `category_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`project_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `projects` (`project_id`, `title`, `description`, `keywords`, `technologies`, `status`, `category_id`, `created_at`) VALUES
(1, 'Web Development Project 1', 'A web development project for learning PHP and MySQL', 'web, php, mysql', 'PHP, MySQL, HTML, CSS', 'open', 1, '2024-12-25 21:48:02'),
(2, 'Data Science Project 1', 'A data analysis project using Python and Pandas', 'data science, python, pandas', 'Python, Pandas, scikit-learn', 'in progress', 2, '2024-12-25 21:48:02'),
(3, 'Test Project', 'This is a test project description.', 'test, example, project', 'PHP, JavaScript, MySQL', 'open', 1, '2024-12-28 12:54:32');

--DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Web Development'),
(2, 'Data Science'),
(3, 'Mobile Development'),
(4, 'Marketing'),
(6, 'AI');

DROP TABLE IF EXISTS `group_members`;
CREATE TABLE IF NOT EXISTS `group_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `student_id` int NOT NULL,
  `role` enum('Leader','Member') DEFAULT 'Member',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



INSERT INTO `group_members` (`id`, `group_id`, `student_id`,'role', `created_at`) VALUES
(1, 1, 1,'Member', '2025-01-03 15:00:25'),
(2, 1, 2,'Member', '2025-01-03 15:00:25');
DROP TABLE IF EXISTS `student_groups`;
CREATE TABLE IF NOT EXISTS `student_groups` (
  `group_id` int NOT NULL AUTO_INCREMENT,
  `leader_id` int NOT NULL,
  `members_count` int DEFAULT '1',
  `max_members` int DEFAULT '3',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;  

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`, `is_read`) VALUES
(1, 1, 'Votre candidature a été acceptée.', '2025-01-03 16:30:25', 0);
