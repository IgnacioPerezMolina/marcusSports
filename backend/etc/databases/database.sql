CREATE TABLE IF NOT EXISTS `user` (
  `id` CHAR(36) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `U_email_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `products` (
  `id` CHAR(36) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `category` VARCHAR(50) NOT NULL,
  `base_price` DECIMAL(10,2) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `part_types` (
    `id` CHAR(36) NOT NULL,
    `product_id` CHAR(36) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `required` TINYINT(1) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_part_types_products` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `part_items` (
    `id` CHAR(36) NOT NULL,
    `part_type_id` CHAR(36) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `status` VARCHAR(20) NOT NULL,
    `attributes` JSON,
    `restrictions` JSON,
    `created_at` DATETIME NOT NULL,
    `updated_at` DATETIME NOT NULL,
    `deleted_at` DATETIME DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `FK_part_items_part_types` FOREIGN KEY (`part_type_id`) REFERENCES `part_types`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `compatibility_rules` (
     `id` CHAR(36) NOT NULL,
     `product_id` CHAR(36) NOT NULL,
     `rule_expression` JSON NOT NULL,
     PRIMARY KEY (`id`),
     CONSTRAINT `FK_compatibility_rules_products` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `price_modifiers` (
     `id` CHAR(36) NOT NULL,
     `product_id` CHAR(36) NOT NULL,
     `modifier_condition` JSON NOT NULL,
     `adjustment` DECIMAL(10,2) NOT NULL,
     `scope` VARCHAR(20) NOT NULL,
     PRIMARY KEY (`id`),
     CONSTRAINT `FK_price_modifiers_products` FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;