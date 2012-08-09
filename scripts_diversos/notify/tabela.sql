-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 09/08/2012 às 19h46min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `sis`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `dti_notificacoes`
--

CREATE TABLE IF NOT EXISTS `dti_notificacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assunto` varchar(15) DEFAULT 'DTI',
  `mensagem` tinytext,
  `ip` text NOT NULL,
  `status` int(1) DEFAULT '1',
  `icone` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `dti_notificacoes`
--

INSERT INTO `dti_notificacoes` (`id`, `assunto`, `mensagem`, `ip`, `status`, `icone`) VALUES
(1, 'DTI', 'Seu IP foi bloqueado por acesso indevido a internet.', '127.0.0.1', 1, 'important');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
