-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 14/08/2012 às 19h27min
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
-- Estrutura da tabela `dti_rede_ips`
--

CREATE TABLE IF NOT EXISTS `dti_rede_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) DEFAULT NULL,
  `local` varchar(100) DEFAULT NULL,
  `label` varchar(30) NOT NULL,
  `descricao` text,
  `origem` int(11) NOT NULL,
  `mediaping` int(6) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dti_rede_pings`
--

CREATE TABLE IF NOT EXISTS `dti_rede_pings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `mediaping` varchar(20) NOT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=739963 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;