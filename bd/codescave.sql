SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema CodesCave
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `CodesCave` DEFAULT CHARACTER SET utf8 ;
USE `CodesCave` ;

-- -----------------------------------------------------
-- Table `CodesCave`.`Usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `role_usuario` INT NOT NULL,
  `nome_usuario` VARCHAR(100) NOT NULL,
  `email_usuario` VARCHAR(100) NOT NULL,
  `senha_usuario` VARCHAR(255) NOT NULL,
  `foto_usuario` LONGBLOB NOT NULL,
  `telefone_usuario` VARCHAR(20),
  `bio_usuario` VARCHAR(255),
  PRIMARY KEY (`idUsuario`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CodesCave`.`Topico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CodesCave`.`Topico` (
  `idTopico` INT NOT NULL AUTO_INCREMENT,
  `nome_topico` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idTopico`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tópicos pré-definidos do fórum
-- -----------------------------------------------------

INSERT INTO `Topico` (`nome_topico`) VALUES ('HTML');
INSERT INTO `Topico` (`nome_topico`) VALUES ('CSS');
INSERT INTO `Topico` (`nome_topico`) VALUES ('JS');
INSERT INTO `Topico` (`nome_topico`) VALUES ('PHP');
INSERT INTO `Topico` (`nome_topico`) VALUES ('Python');
INSERT INTO `Topico` (`nome_topico`) VALUES ('C++');

-- -----------------------------------------------------
-- Table `CodesCave`.`Postagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CodesCave`.`Postagem` (
  `idPostagem` INT NOT NULL AUTO_INCREMENT,
  `conteudo_post` VARCHAR(999) NOT NULL,
  `data_post` DATE NOT NULL,
  `titulo_post` VARCHAR(100) NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  `Topico_idTopico` INT NOT NULL,
  PRIMARY KEY (`idPostagem`, `Usuario_idUsuario`, `Topico_idTopico`),
  INDEX `fk_Postagem_Usuario1_idx` (`Usuario_idUsuario` ASC),
  INDEX `fk_Postagem_Topico1_idx` (`Topico_idTopico` ASC),
  CONSTRAINT `fk_Postagem_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `CodesCave`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postagem_Topico1`
    FOREIGN KEY (`Topico_idTopico`)
    REFERENCES `CodesCave`.`Topico` (`idTopico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CodesCave`.`Comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CodesCave`.`Comentario` (
  `idComentarios` INT NOT NULL AUTO_INCREMENT,
  `conteudo_comentario` VARCHAR(999) NOT NULL,
  `data_comentario` DATETIME NOT NULL,
  `Postagem_idPostagem` INT NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idComentarios`, `Postagem_idPostagem`, `Usuario_idUsuario`),
  INDEX `fk_Comentarios_Postagem1_idx` (`Postagem_idPostagem` ASC),
  INDEX `fk_Comentario_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Comentarios_Postagem1`
    FOREIGN KEY (`Postagem_idPostagem`)
    REFERENCES `CodesCave`.`Postagem` (`idPostagem`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `CodesCave`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `CodesCave`.`Permissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CodesCave`.`Permissao` (
  `idPermissao` INT NOT NULL AUTO_INCREMENT,
  `permissao_nome` VARCHAR(100) NOT NULL,
  `permissao_acoes` VARCHAR(100) NOT NULL,
  `Usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idPermissao`, `Usuario_idUsuario`),
  INDEX `fk_Permissao_Usuario1_idx` (`Usuario_idUsuario` ASC),
  CONSTRAINT `fk_Permissao_Usuario1`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `CodesCave`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;