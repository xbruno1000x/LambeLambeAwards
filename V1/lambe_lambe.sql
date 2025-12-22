-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/10/2024 às 08:03
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lambe_lambe`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'bruno', 'root', '2024-10-03 02:52:43', '2024-10-03 02:52:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(2, 'Torcedor mais insuportável do ano'),
(1, 'Viado do ano');

-- --------------------------------------------------------

--
-- Estrutura para tabela `indicados`
--

CREATE TABLE `indicados` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `indicados`
--

INSERT INTO `indicados` (`id`, `categoria_id`, `nome`) VALUES
(1, 1, 'André Ramos'),
(2, 1, 'Matheus'),
(3, 1, 'Frank'),
(4, 1, 'Iuryck'),
(5, 2, 'Luiza'),
(6, 2, 'Amaduro'),
(7, 2, 'Alencar'),
(8, 2, 'Matheus');

-- --------------------------------------------------------

--
-- Estrutura para tabela `votos`
--

CREATE TABLE `votos` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `indicado_id` int(11) NOT NULL,
  `voto` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `votos`
--

INSERT INTO `votos` (`id`, `categoria_id`, `indicado_id`, `voto`) VALUES
(1, 1, 1, 7),
(7, 2, 6, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `indicados`
--
ALTER TABLE `indicados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices de tabela `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoria_id` (`categoria_id`,`indicado_id`),
  ADD KEY `indicado_id` (`indicado_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `indicados`
--
ALTER TABLE `indicados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `indicados`
--
ALTER TABLE `indicados`
  ADD CONSTRAINT `indicados_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`indicado_id`) REFERENCES `indicados` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
