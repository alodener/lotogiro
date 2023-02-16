drop table if exists users_has_qualifications;

-- tabela de qualificações do usuário
CREATE TABLE if not exists plano.users_has_qualifications (
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