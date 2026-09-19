-- ============================================================
-- Macramê Nós de Lu — Estrutura do banco de dados
-- MySQL / MariaDB (XAMPP)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `macramenosdelu`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `macramenosdelu`;

-- ------------------------------------------------------------
-- Administradores
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `admin_users` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`          VARCHAR(120) NOT NULL,
    `email`         VARCHAR(190) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_admin_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Categorias
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `categories` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(120) NOT NULL,
    `slug`       VARCHAR(140) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Produtos
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `products` (
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id`       INT UNSIGNED NULL,
    `name`              VARCHAR(190) NOT NULL,
    `slug`              VARCHAR(200) NOT NULL,
    `price`             DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `status`            ENUM('ativo','pausado') NOT NULL DEFAULT 'ativo',
    `stock_qty`         INT NOT NULL DEFAULT 0,
    `shopee_url`        VARCHAR(500) NULL,
    `short_description` VARCHAR(500) NULL,
    `description`       TEXT NULL,
    `material`          VARCHAR(190) NULL,
    `dimensions`        VARCHAR(190) NULL,
    `colors`            VARCHAR(190) NULL,
    `production_time`   VARCHAR(190) NULL,
    `artisan_note`      TEXT NULL,
    `care_instructions` TEXT NULL,
    `created_at`        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_products_slug` (`slug`),
    KEY `ix_products_category` (`category_id`),
    KEY `ix_products_status` (`status`),
    CONSTRAINT `fk_products_category`
        FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Mídias do produto (fotos e vídeos)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `product_media` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` INT UNSIGNED NOT NULL,
    `media_type` ENUM('image','video') NOT NULL DEFAULT 'image',
    `file_path`  VARCHAR(500) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ix_product_media_product` (`product_id`),
    CONSTRAINT `fk_product_media_product`
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Pedidos (registro manual de contatos/vendas)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `orders` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_name` VARCHAR(190) NOT NULL,
    `contact`       VARCHAR(190) NULL,
    `channel`       ENUM('whatsapp','shopee','site','outro') NOT NULL DEFAULT 'whatsapp',
    `status`        ENUM('pendente','concluido','cancelado') NOT NULL DEFAULT 'pendente',
    `total`         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `notes`         TEXT NULL,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ix_orders_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Galeria do site
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `gallery_items` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(190) NULL,
    `file_path`  VARCHAR(500) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Links institucionais (footer / contato)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `site_links` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `link_key`   VARCHAR(60) NOT NULL,
    `label`      VARCHAR(120) NOT NULL,
    `url`        VARCHAR(500) NOT NULL,
    `display`    VARCHAR(190) NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active`  TINYINT(1) NOT NULL DEFAULT 1,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_site_links_key` (`link_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Carrossel do hero (home)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `hero_carousel_items` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `media_type` ENUM('image','video') NOT NULL DEFAULT 'image',
    `file_path`  VARCHAR(500) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ix_hero_carousel_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Configurações gerais (chave/valor)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `settings` (
    `setting_key`   VARCHAR(80) NOT NULL,
    `setting_value` TEXT NULL,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Registro de alterações recentes (dashboard)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `activity_log` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `entity_type` VARCHAR(60) NOT NULL,
    `entity_id`   INT UNSIGNED NULL,
    `action`      VARCHAR(60) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `ix_activity_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
