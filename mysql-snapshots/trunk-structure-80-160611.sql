ALTER TABLE `users` ADD `is_teacher` BOOL NOT NULL DEFAULT '0',
ADD `webhuddle_password` VARCHAR( 255 ) NULL DEFAULT NULL ,
ADD INDEX ( `is_teacher` ) 