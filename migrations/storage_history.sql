CREATE TABLE `storage_history` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`item_id` INT(11) NULL DEFAULT '0',
	`warehouse_id` INT(11) NULL DEFAULT '0',
	`action` TINYTEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	`timestamp` DATETIME NULL DEFAULT NULL,
	INDEX `id` (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;