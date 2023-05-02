CREATE TABLE IF NOT EXISTS `bichao_games_vencedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `resultado_id` int(11) NOT NULL,
  `valor_premio` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_resultado_id` (`resultado_id`),
  KEY `fk_game_id` (`game_id`),
  CONSTRAINT `fk_game_id` FOREIGN KEY (`game_id`) REFERENCES `bichao_games` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;