-- MySQL Script generated by MySQL Workbench
-- Sun Jan  1 16:02:01 2023
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema technohouse
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema technohouse
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `technohouse` ;
USE `technohouse` ;

-- -----------------------------------------------------
-- Table `technohouse`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`User` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `phoneNumber` VARCHAR(45) NOT NULL,
  `birthDate` DATE NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `userImage` VARCHAR(256) NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `idUser_UNIQUE` (`idUser` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `phoneNumber_UNIQUE` (`phoneNumber` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Region`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Region` (
  `idRegion` INT NOT NULL AUTO_INCREMENT,
  `regionName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRegion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Province`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Province` (
  `initials` VARCHAR(45) NOT NULL,
  `provinceName` VARCHAR(45) NOT NULL,
  `Region_idRegion` INT NOT NULL,
  INDEX `fk_Province_Region1_idx` (`Region_idRegion` ASC) ,
  PRIMARY KEY (`initials`),
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC) ,
  CONSTRAINT `fk_Province_Region1`
    FOREIGN KEY (`Region_idRegion`)
    REFERENCES `technohouse`.`Region` (`idRegion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`City`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`City` (
  `idCity` INT NOT NULL AUTO_INCREMENT,
  `postCode` VARCHAR(10) NOT NULL,
  `cityName` VARCHAR(45) NOT NULL,
  `Province_initials` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCity`),
  INDEX `fk_City_Province1_idx` (`Province_initials` ASC) ,
  CONSTRAINT `fk_City_Province1`
    FOREIGN KEY (`Province_initials`)
    REFERENCES `technohouse`.`Province` (`initials`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Post` (
  `idPost` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NULL,
  `price` FLOAT NULL,
  `User_idUser` INT NOT NULL,
  `PublishTime` DATETIME NOT NULL,
  `Address` VARCHAR(45) NULL,
  `City_idCity` INT NOT NULL,
  `latitude` DOUBLE NULL,
  `LONGITUDE` DOUBLE NULL,
  PRIMARY KEY (`idPost`),
  UNIQUE INDEX `idPost_UNIQUE` (`idPost` ASC) ,
  INDEX `fk_Post_User1_idx` (`User_idUser` ASC) ,
  INDEX `fk_Post_City1_idx` (`City_idCity` ASC) ,
  CONSTRAINT `fk_Post_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Post_City1`
    FOREIGN KEY (`City_idCity`)
    REFERENCES `technohouse`.`City` (`idCity`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Tag` (
  `idTag` INT NOT NULL AUTO_INCREMENT,
  `tagName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTag`),
  UNIQUE INDEX `idBuilding_UNIQUE` (`idTag` ASC) ,
  UNIQUE INDEX `tagName_UNIQUE` (`tagName` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`SavedPosts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`SavedPosts` (
  `Post_idPost` INT NOT NULL,
  `User_idUser` INT NOT NULL,
  INDEX `fk_SavedPosts_Post1_idx` (`Post_idPost` ASC) ,
  INDEX `fk_SavedPosts_User1_idx` (`User_idUser` ASC) ,
  CONSTRAINT `fk_SavedPosts_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `technohouse`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SavedPosts_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Question` (
  `idQuestion` INT NOT NULL AUTO_INCREMENT,
  `User_idUser` INT NOT NULL,
  `Post_idPost` INT NOT NULL,
  `text` LONGTEXT NOT NULL,
  PRIMARY KEY (`idQuestion`),
  UNIQUE INDEX `idComment_UNIQUE` (`idQuestion` ASC) ,
  INDEX `fk_Comment_User1_idx` (`User_idUser` ASC) ,
  INDEX `fk_Question_Post1_idx` (`Post_idPost` ASC) ,
  CONSTRAINT `fk_Comment_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Question_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `technohouse`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Answer` (
  `idAnswer` INT NOT NULL AUTO_INCREMENT,
  `User_idUser` INT NOT NULL,
  `Question_idQuestion` INT NOT NULL,
  `text` LONGTEXT NOT NULL,
  PRIMARY KEY (`idAnswer`),
  UNIQUE INDEX `idAnswer_UNIQUE` (`idAnswer` ASC) ,
  INDEX `fk_Answer_User1_idx` (`User_idUser` ASC) ,
  INDEX `fk_Answer_Question1_idx` (`Question_idQuestion` ASC) ,
  CONSTRAINT `fk_Answer_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Answer_Question1`
    FOREIGN KEY (`Question_idQuestion`)
    REFERENCES `technohouse`.`Question` (`idQuestion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Image` (
  `idImage` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(256) NOT NULL,
  `Post_idPost` INT NOT NULL,
  PRIMARY KEY (`idImage`),
  UNIQUE INDEX `idImage_UNIQUE` (`idImage` ASC) ,
  INDEX `fk_Image_Post1_idx` (`Post_idPost` ASC) ,
  CONSTRAINT `fk_Image_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `technohouse`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Following`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Following` (
  `User_idUser` INT NOT NULL,
  `User_idUser1` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `User_idUser1`),
  INDEX `fk_User_has_User1_User2_idx` (`User_idUser1` ASC) ,
  INDEX `fk_User_has_User1_User1_idx` (`User_idUser` ASC) ,
  CONSTRAINT `fk_User_has_User1_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_User1_User2`
    FOREIGN KEY (`User_idUser1`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Chat` (
  `idChat` INT NOT NULL AUTO_INCREMENT,
  `User_idUser` INT NOT NULL,
  `User_idUser1` INT NOT NULL,
  PRIMARY KEY (`idChat`),
  INDEX `fk_Chat_User2_idx` (`User_idUser1` ASC) ,
  CONSTRAINT `fk_Chat_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chat_User2`
    FOREIGN KEY (`User_idUser1`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Message` (
  `idMessage` INT NOT NULL AUTO_INCREMENT,
  `body` LONGTEXT NOT NULL,
  `data` DATETIME NOT NULL,
  `User_idUser` INT NOT NULL,
  `Chat_idChat` INT NOT NULL,
  PRIMARY KEY (`idMessage`),
  UNIQUE INDEX `idMessage_UNIQUE` (`idMessage` ASC) ,
  INDEX `fk_Message_User1_idx` (`User_idUser` ASC) ,
  INDEX `fk_Message_Chat1_idx` (`Chat_idChat` ASC) ,
  CONSTRAINT `fk_Message_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Message_Chat1`
    FOREIGN KEY (`Chat_idChat`)
    REFERENCES `technohouse`.`Chat` (`idChat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Post_has_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Post_has_Tag` (
  `Post_idPost` INT NOT NULL,
  `Tag_idTag` INT NOT NULL,
  PRIMARY KEY (`Post_idPost`, `Tag_idTag`),
  INDEX `fk_Post_has_Tag_Tag1_idx` (`Tag_idTag` ASC) ,
  INDEX `fk_Post_has_Tag_Post1_idx` (`Post_idPost` ASC) ,
  CONSTRAINT `fk_Post_has_Tag_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `technohouse`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Post_has_Tag_Tag1`
    FOREIGN KEY (`Tag_idTag`)
    REFERENCES `technohouse`.`Tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `technohouse`.`Notification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `technohouse`.`Notification` (
  `idNotification` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(250) NOT NULL,
  `targetUser` INT NOT NULL,
  `Post_idPost` INT NULL,
  `User_idUser` INT NULL,
  `time` DATETIME NOT NULL,
  `Chat_idChat` INT NULL,
  PRIMARY KEY (`idNotification`),
  UNIQUE INDEX `idNotification_UNIQUE` (`idNotification` ASC) ,
  INDEX `fk_Notification_User1_idx` (`targetUser` ASC) ,
  INDEX `fk_Notification_Post1_idx` (`Post_idPost` ASC) ,
  INDEX `fk_Notification_User2_idx` (`User_idUser` ASC) ,
  INDEX `fk_Notification_Chat1_idx` (`Chat_idChat` ASC) ,
  CONSTRAINT `fk_Notification_User1`
    FOREIGN KEY (`targetUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Notification_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `technohouse`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Notification_User2`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `technohouse`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Notification_Chat1`
    FOREIGN KEY (`Chat_idChat`)
    REFERENCES `technohouse`.`Chat` (`idChat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

ALTER TABLE SavedPosts
ADD PRIMARY KEY (User_idUser, Post_idPost);