SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_myblog
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_myblog` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_myblog` ;

-- -----------------------------------------------------
-- Table `db_myblog`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_myblog`.`user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `role` VARCHAR(13) NOT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_myblog`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_myblog`.`post` (
                                                  `id` INT NOT NULL AUTO_INCREMENT,
                                                  `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `chapo` TEXT(650000) NOT NULL,
    `content` TEXT(650000) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `update_at` DATETIME NOT NULL,
    `user_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_post_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `db_myblog`.`user` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
    ENGINE = InnoDB;

CREATE INDEX `fk_post_user1_idx` ON `db_myblog`.`post` (`user_id` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `db_myblog`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_myblog`.`category` (
                                                      `id` INT NOT NULL AUTO_INCREMENT,
                                                      `name` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_myblog`.`post_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_myblog`.`post_category` (
                                                           `post_id` INT NOT NULL,
                                                           `category_id` INT NOT NULL,
                                                           PRIMARY KEY (`post_id`, `category_id`),
    CONSTRAINT `fk_table1_post`
    FOREIGN KEY (`post_id`)
    REFERENCES `db_myblog`.`post` (`id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
    CONSTRAINT `fk_table1_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `db_myblog`.`category` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
    ENGINE = InnoDB;

CREATE INDEX `fk_table1_category1_idx` ON `db_myblog`.`post_category` (`category_id` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `db_myblog`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_myblog`.`comment` (
                                                     `id` INT NOT NULL AUTO_INCREMENT,
                                                     `content` TEXT(650000) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `status` INT NOT NULL,
    `post_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_comments_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `db_myblog`.`post` (`id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
    CONSTRAINT `fk_comment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `db_myblog`.`user` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
    ENGINE = InnoDB;

CREATE INDEX `fk_comments_post1_idx` ON `db_myblog`.`comment` (`post_id` ASC) VISIBLE;

CREATE INDEX `fk_comment_user1_idx` ON `db_myblog`.`comment` (`user_id` ASC) VISIBLE;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
