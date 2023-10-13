ALTER TABLE users ADD commission_lv_1 varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0' AFTER commission;
ALTER TABLE users ADD commission_lv_2 varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0' AFTER commission_lv_1;

ALTER TABLE users ADD commission_individual JSON DEFAULT NULL AFTER commission_lv_2;
ALTER TABLE users ADD commission_individual_lv_1 JSON DEFAULT NULL AFTER commission_individual;
ALTER TABLE users ADD commission_individual_lv_2 JSON DEFAULT NULL AFTER commission_individual_lv_1;

ALTER TABLE users ADD commission_individual_bichao JSON DEFAULT NULL AFTER commission_individual_lv_2;
ALTER TABLE users ADD commission_individual_bichao_lv_1 JSON DEFAULT NULL AFTER commission_individual_bichao;
ALTER TABLE users ADD commission_individual_bichao_lv_2 JSON DEFAULT NULL AFTER commission_individual_bichao_lv_1;

ALTER TABLE games ADD commission_value_avo varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER commision_value_pai;
ALTER TABLE bichao_games ADD comission_value_avo varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER comission_value_pai;