
-- Wed Mar  9 22:13:33 2022
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
-- Table `mydb`.`SubjectsMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`SubjectsMaster` (
  `subject_id` INT NOT NULL AUTO_INCREMENT,
  `subject_name` NVARCHAR(50) NOT NULL,
  PRIMARY KEY (`subject_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UnitsMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UnitsMaster` (
  `unit_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`unit_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UnitsSubjects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UnitsSubjects` (
  `SubjectsMaster_subject_id` INT NOT NULL,
  `UnitsMaster_unit_id` INT NOT NULL,
  PRIMARY KEY (`SubjectsMaster_subject_id`, `UnitsMaster_unit_id`),
  INDEX `fk_SubjectsMaster_has_UnitsMaster_UnitsMaster1_idx` (`UnitsMaster_unit_id` ASC) VISIBLE,
  INDEX `fk_SubjectsMaster_has_UnitsMaster_SubjectsMaster_idx` (`SubjectsMaster_subject_id` ASC) VISIBLE,
  CONSTRAINT `fk_SubjectsMaster_has_UnitsMaster_SubjectsMaster`
    FOREIGN KEY (`SubjectsMaster_subject_id`)
    REFERENCES `mydb`.`SubjectsMaster` (`subject_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_SubjectsMaster_has_UnitsMaster_UnitsMaster1`
    FOREIGN KEY (`UnitsMaster_unit_id`)
    REFERENCES `mydb`.`UnitsMaster` (`unit_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`LevelsMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`LevelsMaster` (
  `level_id` INT NOT NULL AUTO_INCREMENT,
  `level_value` TINYINT(6) NOT NULL,
  `level_name` NVARCHAR(50) NOT NULL,
  `exp_for_level_up` INT NOT NULL,
  PRIMARY KEY (`level_id`),
  UNIQUE INDEX `level_value_UNIQUE` (`level_value` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `inscription_date` DATE GENERATED ALWAYS AS () VIRTUAL,
  `language_id` INT NOT NULL,
  `mail_adress` CHAR(255) NOT NULL,
  `Userscol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_name_UNIQUE` (`user_name` ASC) VISIBLE,
  UNIQUE INDEX `Userscol_UNIQUE` (`Userscol` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UsersUnitsLevels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UsersUnitsLevels` (
  `Users_user_id` INT NOT NULL,
  `UnitsMaster_unit_id` INT NOT NULL,
  `LevelsMaster_level_id` INT NOT NULL,
  PRIMARY KEY (`Users_user_id`, `UnitsMaster_unit_id`),
  INDEX `fk_Users_has_UnitsMaster_UnitsMaster1_idx` (`UnitsMaster_unit_id` ASC) VISIBLE,
  INDEX `fk_Users_has_UnitsMaster_Users1_idx` (`Users_user_id` ASC) VISIBLE,
  INDEX `fk_UsersUnitsLevels_LevelsMaster1_idx` (`LevelsMaster_level_id` ASC) VISIBLE,
  CONSTRAINT `fk_Users_has_UnitsMaster_Users1`
    FOREIGN KEY (`Users_user_id`)
    REFERENCES `mydb`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_UnitsMaster_UnitsMaster1`
    FOREIGN KEY (`UnitsMaster_unit_id`)
    REFERENCES `mydb`.`UnitsMaster` (`unit_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UsersUnitsLevels_LevelsMaster1`
    FOREIGN KEY (`LevelsMaster_level_id`)
    REFERENCES `mydb`.`LevelsMaster` (`level_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NotionsMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`NotionsMaster` (
  `notion_id` INT NOT NULL,
  `LevelsMaster_level_id` INT NOT NULL,
  `UnitsMaster_unit_id` INT NOT NULL,
  `notion_name` NVARCHAR(63) NOT NULL,
  PRIMARY KEY (`notion_id`),
  INDEX `fk_LevelsMaster_has_UnitsMaster_UnitsMaster1_idx` (`UnitsMaster_unit_id` ASC) VISIBLE,
  INDEX `fk_LevelsMaster_has_UnitsMaster_LevelsMaster1_idx` (`LevelsMaster_level_id` ASC) VISIBLE,
  UNIQUE INDEX `notion_id_UNIQUE` (`notion_id` ASC) VISIBLE,
  CONSTRAINT `fk_LevelsMaster_has_UnitsMaster_LevelsMaster1`
    FOREIGN KEY (`LevelsMaster_level_id`)
    REFERENCES `mydb`.`LevelsMaster` (`level_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LevelsMaster_has_UnitsMaster_UnitsMaster1`
    FOREIGN KEY (`UnitsMaster_unit_id`)
    REFERENCES `mydb`.`UnitsMaster` (`unit_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`QuestionsTypes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`QuestionsTypes` (
  `question_type_id` INT NOT NULL AUTO_INCREMENT,
  `type_name` NVARCHAR(20) NOT NULL,
  PRIMARY KEY (`question_type_id`),
  UNIQUE INDEX `type_name_UNIQUE` (`type_name` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`QuestionsComplexities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`QuestionsComplexities` (
  `complexity_id` INT NOT NULL AUTO_INCREMENT,
  `estimated_duration_seconds` INT(7) NOT NULL,
  `experience_points` INT NULL,
  PRIMARY KEY (`complexity_id`),
  UNIQUE INDEX `estimated_duration_seconds_UNIQUE` (`estimated_duration_seconds` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`QuestionsMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`QuestionsMaster` (
  `question_id` INT NOT NULL AUTO_INCREMENT,
  `notion_id` INT NOT NULL,
  `question_type_id` INT NOT NULL,
  `is_illustrated` TINYINT NOT NULL DEFAULT 0,
  `complexity_id` INT NOT NULL,
  PRIMARY KEY (`question_id`),
  INDEX `fk_QuestionsMaster_NotionsMaster1_idx` (`notion_id` ASC) VISIBLE,
  INDEX `fk_QuestionsMaster_QuestionsTypes1_idx` (`question_type_id` ASC) VISIBLE,
  INDEX `fk_QuestionsMaster_QuestionsComplexities1_idx` (`complexity_id` ASC) VISIBLE,
  CONSTRAINT `fk_QuestionsMaster_NotionsMaster1`
    FOREIGN KEY (`notion_id`)
    REFERENCES `mydb`.`NotionsMaster` (`notion_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_QuestionsMaster_QuestionsTypes1`
    FOREIGN KEY (`question_type_id`)
    REFERENCES `mydb`.`QuestionsTypes` (`question_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_QuestionsMaster_QuestionsComplexities1`
    FOREIGN KEY (`complexity_id`)
    REFERENCES `mydb`.`QuestionsComplexities` (`complexity_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`QuestionsImages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`QuestionsImages` (
  `question_image_id` INT NOT NULL AUTO_INCREMENT,
  `image_path` VARCHAR(200) NOT NULL,
  `image_order` TINYINT(2) NOT NULL,
  `is_instruction` TINYINT NOT NULL,
  `question_id` INT NOT NULL,
  PRIMARY KEY (`question_image_id`),
  INDEX `fk_QuestionsImages_QuestionsMaster1_idx` (`question_id` ASC) VISIBLE,
  CONSTRAINT `fk_QuestionsImages_QuestionsMaster1`
    FOREIGN KEY (`question_id`)
    REFERENCES `mydb`.`QuestionsMaster` (`question_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`PossibleAnswersMaster`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`PossibleAnswersMaster` (
  `possible_answer_id` INT NOT NULL,
  `answer_text` NVARCHAR(1023) NOT NULL,
  `is_correct_answer` TINYINT NOT NULL DEFAULT 0,
  `question_id` INT NOT NULL,
  PRIMARY KEY (`possible_answer_id`),
  INDEX `fk_PossibleAnswersMaster_QuestionsMaster1_idx` (`question_id` ASC) VISIBLE,
  CONSTRAINT `fk_PossibleAnswersMaster_QuestionsMaster1`
    FOREIGN KEY (`question_id`)
    REFERENCES `mydb`.`QuestionsMaster` (`question_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NotionsDependencies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`NotionsDependencies` (
  `dependent_notion_id` INT NOT NULL,
  `requisite_notion_id` INT NOT NULL,
  PRIMARY KEY (`dependent_notion_id`, `requisite_notion_id`),
  INDEX `fk_NotionsMaster_has_NotionsMaster_NotionsMaster2_idx` (`requisite_notion_id` ASC) VISIBLE,
  INDEX `fk_NotionsMaster_has_NotionsMaster_NotionsMaster1_idx` (`dependent_notion_id` ASC) VISIBLE,
  CONSTRAINT `fk_NotionsMaster_has_NotionsMaster_NotionsMaster1`
    FOREIGN KEY (`dependent_notion_id`)
    REFERENCES `mydb`.`NotionsMaster` (`notion_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_NotionsMaster_has_NotionsMaster_NotionsMaster2`
    FOREIGN KEY (`requisite_notion_id`)
    REFERENCES `mydb`.`NotionsMaster` (`notion_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`NotionsProficiencies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`NotionsProficiencies` (
  `proficiency_id` INT NOT NULL,
  `proficiency_value` INT(1) NOT NULL,
  PRIMARY KEY (`proficiency_id`),
  UNIQUE INDEX `proficiency_value_UNIQUE` (`proficiency_value` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UsersNotions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UsersNotions` (
  `user_id` INT NOT NULL,
  `notion_id` INT NOT NULL,
  `NotionsProficiencies_proficiency_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `notion_id`),
  INDEX `fk_Users_has_NotionsMaster_NotionsMaster1_idx` (`notion_id` ASC) VISIBLE,
  INDEX `fk_Users_has_NotionsMaster_Users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_UsersNotions_NotionsProficiencies1_idx` (`NotionsProficiencies_proficiency_id` ASC) VISIBLE,
  CONSTRAINT `fk_Users_has_NotionsMaster_Users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_NotionsMaster_NotionsMaster1`
    FOREIGN KEY (`notion_id`)
    REFERENCES `mydb`.`NotionsMaster` (`notion_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_UsersNotions_NotionsProficiencies1`
    FOREIGN KEY (`NotionsProficiencies_proficiency_id`)
    REFERENCES `mydb`.`NotionsProficiencies` (`proficiency_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UserFailedQuestions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UserFailedQuestions` (
  `QuestionsMaster_question_id` INT NOT NULL,
  `Users_user_id` INT NOT NULL,
  `last_attempt` DATE GENERATED ALWAYS AS () VIRTUAL,
  PRIMARY KEY (`QuestionsMaster_question_id`, `Users_user_id`),
  INDEX `fk_QuestionsMaster_has_Users_Users1_idx` (`Users_user_id` ASC) VISIBLE,
  INDEX `fk_QuestionsMaster_has_Users_QuestionsMaster1_idx` (`QuestionsMaster_question_id` ASC) VISIBLE,
  CONSTRAINT `fk_QuestionsMaster_has_Users_QuestionsMaster1`
    FOREIGN KEY (`QuestionsMaster_question_id`)
    REFERENCES `mydb`.`QuestionsMaster` (`question_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_QuestionsMaster_has_Users_Users1`
    FOREIGN KEY (`Users_user_id`)
    REFERENCES `mydb`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`UsersCurrentQuestions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`UsersCurrentQuestions` (
  `Users_user_id` INT NOT NULL,
  `QuestionsMaster_question_id` INT NOT NULL,
  PRIMARY KEY (`Users_user_id`, `QuestionsMaster_question_id`),
  INDEX `fk_Users_has_QuestionsMaster_QuestionsMaster1_idx` (`QuestionsMaster_question_id` ASC) VISIBLE,
  INDEX `fk_Users_has_QuestionsMaster_Users1_idx` (`Users_user_id` ASC) VISIBLE,
  CONSTRAINT `fk_Users_has_QuestionsMaster_Users1`
    FOREIGN KEY (`Users_user_id`)
    REFERENCES `mydb`.`Users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_QuestionsMaster_QuestionsMaster1`
    FOREIGN KEY (`QuestionsMaster_question_id`)
    REFERENCES `mydb`.`QuestionsMaster` (`question_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
