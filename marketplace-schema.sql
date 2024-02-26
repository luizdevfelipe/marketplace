-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `marketplace`
--
CREATE DATABASE IF NOT EXISTS `marketplace` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `marketplace`;

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `sobrenome` varchar(20) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cidade` varchar(20) DEFAULT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` float DEFAULT NULL,
  `estoque` int(11) NOT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `vendedor` int(11) DEFAULT NULL,
  FOREIGN KEY (`vendedor`) REFERENCES usuarios(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `iduser` int(11) DEFAULT NULL,
  `idproduto` int(11) DEFAULT NULL,
  FOREIGN KEY (`idproduto`) REFERENCES produtos(`id`),
  FOREIGN KEY (`iduser`) REFERENCES usuarios(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data` date NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idproduto` int(11) DEFAULT NULL,
  FOREIGN KEY (`idproduto`) REFERENCES produtos(`id`),
  FOREIGN KEY (`iduser`) REFERENCES usuarios(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
