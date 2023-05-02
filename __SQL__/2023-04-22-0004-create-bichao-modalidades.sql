CREATE TABLE IF NOT EXISTS `bichao_modalidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multiplicador` int(200) DEFAULT NULL,
  `multiplicador_2` int(200) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bichao_modalidades` (`id`, `nome`, `multiplicador`, `multiplicador_2`, `updated_at`) VALUES
	(1, 'Milhar', 5000, NULL, '2023-04-21 19:52:26'),
	(2, 'Centena', 600, NULL, '2023-04-21 19:52:26'),
	(3, 'Dezena', 60, NULL, '2023-04-21 19:52:26'),
	(4, 'Grupo', 18, NULL, '2023-04-21 19:52:26'),
	(5, 'Milhar/Centena', 5000, 600, NULL),
	(6, 'Terno de Dezena', 5000, NULL, '2023-04-21 19:52:26'),
	(7, 'Terno de Grupos', 1300, 150, '2023-04-21 19:52:26'),
	(8, 'Duque de Dezena', 300, NULL, '2023-04-21 19:52:26'),
	(9, 'Duque de Grupo', 16, NULL, '2023-04-21 19:52:26');