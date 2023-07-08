CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` TINYTEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`email` TINYTEXT NOT NULL COLLATE 'latin1_swedish_ci',
	`password` TINYTEXT NOT NULL COLLATE 'latin1_swedish_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;
