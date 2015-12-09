ALTER TABLE `users` ADD `member_id` INT NOT NULL DEFAULT '0',
ADD INDEX ( `member_id` ) 