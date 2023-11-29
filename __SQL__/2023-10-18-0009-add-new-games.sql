ALTER TABLE bichao_games ADD game_4 varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER game_3;
ALTER TABLE bichao_games ADD game_5 varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER game_4;

INSERT INTO bichao_modalidades (nome, multiplicador, premio_maximo) VALUES ('Quadra de Grupo', 1300, 5000);
INSERT INTO bichao_modalidades (nome, multiplicador, premio_maximo) VALUES ('Quina de Grupo', 1300, 5000);
INSERT INTO bichao_modalidades (nome, multiplicador, premio_maximo) VALUES ('Unidade', 1300, 5000);
INSERT INTO bichao_modalidades (nome, multiplicador, premio_maximo) VALUES ('Milhar Invertida', 5000, 5000);
INSERT INTO bichao_modalidades (nome, multiplicador, premio_maximo) VALUES ('Centena Invertida',600, 5000);