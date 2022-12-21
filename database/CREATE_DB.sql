-- MySQL Script generated by MySQL Workbench
-- mer 21 dic 2022, 10:45:16
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `idUser` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `phoneNumber` VARCHAR(45) NOT NULL,
  `birthDate` DATE NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `biography` LONGTEXT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `idUser_UNIQUE` (`idUser` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  UNIQUE INDEX `phoneNumber_UNIQUE` (`phoneNumber` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Region`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Region` (
  `idRegion` INT NOT NULL,
  `regionName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRegion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Province`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Province` (
  `idProvince` INT NOT NULL,
  `initials` VARCHAR(45) NOT NULL,
  `provinceName` VARCHAR(45) NOT NULL,
  `Region_idRegion` INT NOT NULL,
  PRIMARY KEY (`idProvince`),
  UNIQUE INDEX `idProvince_UNIQUE` (`idProvince` ASC) VISIBLE,
  INDEX `fk_Province_Region1_idx` (`Region_idRegion` ASC) VISIBLE,
  CONSTRAINT `fk_Province_Region1`
    FOREIGN KEY (`Region_idRegion`)
    REFERENCES `mydb`.`Region` (`idRegion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`City`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`City` (
  `postCode` INT NOT NULL,
  `cityName` VARCHAR(45) NOT NULL,
  `Province_idProvince` INT NOT NULL,
  PRIMARY KEY (`postCode`),
  UNIQUE INDEX `idCity_UNIQUE` (`postCode` ASC) VISIBLE,
  INDEX `fk_City_Province1_idx` (`Province_idProvince` ASC) VISIBLE,
  CONSTRAINT `fk_City_Province1`
    FOREIGN KEY (`Province_idProvince`)
    REFERENCES `mydb`.`Province` (`idProvince`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Building`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Building` (
  `idBuilding` INT NOT NULL,
  `coordinates` POINT NOT NULL,
  `City_postCode` INT NOT NULL,
  PRIMARY KEY (`idBuilding`),
  UNIQUE INDEX `idBuilding_UNIQUE` (`idBuilding` ASC) VISIBLE,
  INDEX `fk_Building_City1_idx` (`City_postCode` ASC) VISIBLE,
  CONSTRAINT `fk_Building_City1`
    FOREIGN KEY (`City_postCode`)
    REFERENCES `mydb`.`City` (`postCode`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Post` (
  `idPost` INT NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NULL,
  `price` FLOAT NULL,
  `User_idUser` INT NOT NULL,
  `Building_idBuilding` INT NOT NULL,
  PRIMARY KEY (`idPost`),
  UNIQUE INDEX `idPost_UNIQUE` (`idPost` ASC) VISIBLE,
  INDEX `fk_Post_User1_idx` (`User_idUser` ASC) VISIBLE,
  INDEX `fk_Post_Building1_idx` (`Building_idBuilding` ASC) VISIBLE,
  CONSTRAINT `fk_Post_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Post_Building1`
    FOREIGN KEY (`Building_idBuilding`)
    REFERENCES `mydb`.`Building` (`idBuilding`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Tag` (
  `idTag` INT NOT NULL,
  `tagName` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTag`),
  UNIQUE INDEX `idBuilding_UNIQUE` (`idTag` ASC) VISIBLE,
  UNIQUE INDEX `tagName_UNIQUE` (`tagName` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`SavedPosts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`SavedPosts` (
  `Post_idPost` INT NOT NULL,
  `User_idUser` INT NOT NULL,
  INDEX `fk_SavedPosts_Post1_idx` (`Post_idPost` ASC) VISIBLE,
  INDEX `fk_SavedPosts_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_SavedPosts_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `mydb`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SavedPosts_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Question` (
  `idQuestion` INT NOT NULL,
  `User_idUser` INT NOT NULL,
  `Post_idPost` INT NOT NULL,
  PRIMARY KEY (`idQuestion`),
  UNIQUE INDEX `idComment_UNIQUE` (`idQuestion` ASC) VISIBLE,
  INDEX `fk_Comment_User1_idx` (`User_idUser` ASC) VISIBLE,
  INDEX `fk_Question_Post1_idx` (`Post_idPost` ASC) VISIBLE,
  CONSTRAINT `fk_Comment_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Question_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `mydb`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Answer` (
  `idAnswer` INT NOT NULL,
  `User_idUser` INT NOT NULL,
  `Question_idQuestion` INT NOT NULL,
  PRIMARY KEY (`idAnswer`),
  UNIQUE INDEX `idAnswer_UNIQUE` (`idAnswer` ASC) VISIBLE,
  INDEX `fk_Answer_User1_idx` (`User_idUser` ASC) VISIBLE,
  INDEX `fk_Answer_Question1_idx` (`Question_idQuestion` ASC) VISIBLE,
  CONSTRAINT `fk_Answer_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Answer_Question1`
    FOREIGN KEY (`Question_idQuestion`)
    REFERENCES `mydb`.`Question` (`idQuestion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Image` (
  `idImage` INT NOT NULL,
  `path` VARCHAR(45) NULL,
  `Post_User_idUser` INT NOT NULL,
  `Post_Building_idBuilding` INT NOT NULL,
  `Post_idPost` INT NOT NULL,
  PRIMARY KEY (`idImage`),
  UNIQUE INDEX `idImage_UNIQUE` (`idImage` ASC) VISIBLE,
  INDEX `fk_Image_Post1_idx` (`Post_idPost` ASC) VISIBLE,
  CONSTRAINT `fk_Image_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `mydb`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Follower`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Follower` (
  `User_idUser` INT NOT NULL,
  `User_idUser1` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `User_idUser1`),
  INDEX `fk_User_has_User_User2_idx` (`User_idUser1` ASC) VISIBLE,
  INDEX `fk_User_has_User_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_User_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_User_User2`
    FOREIGN KEY (`User_idUser1`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Following`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Following` (
  `User_idUser` INT NOT NULL,
  `User_idUser1` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `User_idUser1`),
  INDEX `fk_User_has_User1_User2_idx` (`User_idUser1` ASC) VISIBLE,
  INDEX `fk_User_has_User1_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_User1_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_User1_User2`
    FOREIGN KEY (`User_idUser1`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Chat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Chat` (
  `User_idUser` INT NOT NULL,
  `User_idUser1` INT NOT NULL,
  PRIMARY KEY (`User_idUser`, `User_idUser1`),
  INDEX `fk_Chat_User2_idx` (`User_idUser1` ASC) VISIBLE,
  CONSTRAINT `fk_Chat_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Chat_User2`
    FOREIGN KEY (`User_idUser1`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Message` (
  `idMessage` INT NOT NULL,
  `body` LONGTEXT NOT NULL,
  `data` DATETIME NOT NULL,
  `Chat_User_idUser` INT NOT NULL,
  `Chat_User_idUser1` INT NOT NULL,
  `User_idUser` INT NOT NULL,
  PRIMARY KEY (`idMessage`),
  UNIQUE INDEX `idMessage_UNIQUE` (`idMessage` ASC) VISIBLE,
  INDEX `fk_Message_Chat1_idx` (`Chat_User_idUser` ASC, `Chat_User_idUser1` ASC) VISIBLE,
  INDEX `fk_Message_User1_idx` (`User_idUser` ASC) VISIBLE,
  CONSTRAINT `fk_Message_Chat1`
    FOREIGN KEY (`Chat_User_idUser` , `Chat_User_idUser1`)
    REFERENCES `mydb`.`Chat` (`User_idUser` , `User_idUser1`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Message_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Post_has_Tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Post_has_Tag` (
  `Post_idPost` INT NOT NULL,
  `Tag_idTag` INT NOT NULL,
  PRIMARY KEY (`Post_idPost`, `Tag_idTag`),
  INDEX `fk_Post_has_Tag_Tag1_idx` (`Tag_idTag` ASC) VISIBLE,
  INDEX `fk_Post_has_Tag_Post1_idx` (`Post_idPost` ASC) VISIBLE,
  CONSTRAINT `fk_Post_has_Tag_Post1`
    FOREIGN KEY (`Post_idPost`)
    REFERENCES `mydb`.`Post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Post_has_Tag_Tag1`
    FOREIGN KEY (`Tag_idTag`)
    REFERENCES `mydb`.`Tag` (`idTag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;