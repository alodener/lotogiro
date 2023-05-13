CREATE TABLE IF NOT EXISTS `bichao_resultados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `horario_id` int(11) DEFAULT NULL,
  `premio_1` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premio_2` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premio_3` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premio_4` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premio_5` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_horario` (`horario_id`),
  CONSTRAINT `fk_horario` FOREIGN KEY (`horario_id`) REFERENCES `bichao_horarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;