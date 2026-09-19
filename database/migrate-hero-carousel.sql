-- Aplica em bancos já existentes (phpMyAdmin ou mysql CLI).

USE `macramenosdelu`;

CREATE TABLE IF NOT EXISTS `hero_carousel_items` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `media_type` ENUM('image','video') NOT NULL DEFAULT 'image',
    `file_path`  VARCHAR(500) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ix_hero_carousel_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
