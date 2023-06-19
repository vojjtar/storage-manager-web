CREATE TABLE `warehouse` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
	`location` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
	`email` VARCHAR(64) NOT NULL COLLATE 'latin1_swedish_ci',
	`created` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=12
;
