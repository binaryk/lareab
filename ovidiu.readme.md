#1. Am create campul tip_achizitie:TEXT in tabela ach_template_achizitii

#2. am pus la campul data_semnare_cf din tabela ach_template_achizitii pe DATE si am bifat "allow NULL"

#3. Nu cred ca functioneaza bine "Plafon maxim"

#4. Nu functioneaza bine "data_semnare_cf"

#5. Am creat tabela
CREATE TABLE `ach_dosare_achizitii` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`document_necesar` VARCHAR(128) NULL DEFAULT NULL,
	`id_template_achizitii` INT(10) UNSIGNED NOT NULL COMMENT '---> ach_template_achizitii',
	`tip_dosar` VARCHAR(32) NOT NULL COMMENT 'Valori posibile: achizitor|ofertant',
	`numar_ordine` INT(4) NOT NULL,
	`id_clasificare_documente` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT '---> ach_clasificare_documente',
	`mod_solicitare` VARCHAR(32) NOT NULL COMMENT 'Valori posibile: obligatoriu, optional',
	`mod_predare` VARCHAR(32) NOT NULL COMMENT 'Valori posibile: original, copie, copie legalizata',
	`observatii` TEXT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `FK_ach_dosare_achizitii_ach_clasificare_documente` (`id_clasificare_documente`),
	INDEX `FK_ach_dosare_achizitii_ach_template_achizitii` (`id_template_achizitii`),
	CONSTRAINT `FK_ach_dosare_achizitii_ach_clasificare_documente` FOREIGN KEY (`id_clasificare_documente`) REFERENCES `ach_clasificare_documente` (`id`) ON UPDATE CASCADE,
	CONSTRAINT `FK_ach_dosare_achizitii_ach_template_achizitii` FOREIGN KEY (`id_template_achizitii`) REFERENCES `ach_template_achizitii` (`id`) ON UPDATE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4;

#6. CREATE TABLE `ach_proiecte` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`titlu` VARCHAR(128) NOT NULL,
	`tip_achizitor` VARCHAR(128) NOT NULL COMMENT 'Public / Privat',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`deleted_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6;

#7. 