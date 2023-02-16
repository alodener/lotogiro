--tabelas de pontos do usuário
CREATE TABLE plano.users_has_points (
	id bigint auto_increment NOT NULL,
	user_id bigint NOT NULL,
	origin_id bigint NOT NULL,
	`level` int NOT NULL,
    `description` varchar(250) NULL,
	total decimal(18,4) NOT NULL,
	personal_balance decimal(18,4) NOT NULL,
	group_balance decimal(18,4) NOT NULL,
	total_balance decimal(18,4) NOT NULL,
	created_at datetime NOT NULL,
	CONSTRAINT users_has_points_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
CREATE INDEX users_has_points_user_id_IDX USING BTREE ON plano.users_has_points (user_id);
CREATE INDEX users_has_points_origin_id_IDX USING BTREE ON plano.users_has_points (origin_id);
CREATE INDEX users_has_points_level_IDX USING BTREE ON plano.users_has_points (`level`);


-- tabela de configuração das qualificações
CREATE TABLE plano.qualifications (
	id int auto_increment NOT NULL,
	`description` varchar(150) NOT NULL,
	`image` varchar(250) NULL,
	goal decimal(18,4) NOT NULL,
	personal_percentage decimal(18,4) NOT NULL,
	group_percentage decimal(18,4) NOT NULL,
	created_at datetime NOT NULL,
    updated_at datetime NULL,
	CONSTRAINT qualifications_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
CREATE INDEX qualifications_goal_IDX USING BTREE ON plano.qualifications (goal DESC);

-- tabela de qualificações do usuário
CREATE TABLE plano.users_has_qualifications (
	id bigint auto_increment NOT NULL,
	user_id bigint NOT NULL,
	qualification_id int NOT NULL,
	personal_points double DEFAULT NULL,
	group_points double DEFAULT NULL,
	total_points double DEFAULT NULL,
	active smallint(1) NOT NULL,
	created_at datetime NOT NULL,
	CONSTRAINT users_has_qualifications_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;
CREATE INDEX users_has_qualifications_user_id_IDX USING BTREE ON plano.users_has_qualifications (user_id);
CREATE INDEX users_has_qualifications_qualification_id_IDX USING BTREE ON plano.users_has_qualifications (qualification_id);
CREATE INDEX users_has_qualifications_active_IDX USING BTREE ON plano.users_has_qualifications (active);