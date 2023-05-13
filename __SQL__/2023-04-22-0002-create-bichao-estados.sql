CREATE TABLE IF NOT EXISTS `bichao_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uf` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bichao_estados` (`id`, `nome`, `uf`, `active`, `updated_at`) VALUES
	(1, 'Rio de Janeiro', 'RJ', 0, '2023-04-21 19:52:26'),
	(2, 'São Paulo', 'SP', 0, '2023-04-21 19:52:26'),
	(3, 'Goiás', 'GO', 1, '2023-04-21 19:52:26'),
	(4, 'Minas Gerais', 'MG', 1, '2023-04-21 19:52:26'),
	(5, 'Bahia', 'BA', 1, '2023-04-21 19:52:26'),
	(6, 'Paraíba', 'PB', 1, '2023-04-21 19:52:26'),
	(7, 'Brasília', 'DF', 1, '2023-04-21 19:52:26'),
	(8, 'Ceará', 'CE', 1, '2023-04-21 19:52:26');