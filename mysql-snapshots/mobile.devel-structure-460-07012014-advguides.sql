ALTER TABLE  `adv_guides` ADD  `published` BOOLEAN NOT NULL DEFAULT FALSE ,
ADD INDEX (  `published` )