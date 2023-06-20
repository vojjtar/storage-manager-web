CREATE TABLE `storage_history` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`storage_id` INT(11) NULL DEFAULT '0',
	`from_warehouse_id` INT(11) NULL DEFAULT '0',
	`to_warehouse_id` INT(11) NULL DEFAULT NULL,
	`timestamp` DATETIME NULL DEFAULT NULL,
	INDEX `id` (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
;
