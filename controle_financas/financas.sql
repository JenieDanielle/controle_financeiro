-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2024 às 01:56
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `financas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL,
  `descricao_categoria` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome_categoria`, `descricao_categoria`) VALUES
(16, 'Lazer', 'Comprei um pote de sorvete de morango trufado'),
(17, 'Faculdade', 'Mensalidade da faculdade'),
(18, 'Salario', 'Salario mensal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mes`
--

CREATE TABLE `mes` (
  `id_mes` int(11) NOT NULL,
  `nome_mes` enum('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro') NOT NULL,
  `ano_mes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `mes`
--

INSERT INTO `mes` (`id_mes`, `nome_mes`, `ano_mes`) VALUES
(8, 'Setembro', 2024),
(9, 'Outubro', 2024),
(10, 'Novembro', 2024);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL,
  `data_movimentacao` date NOT NULL,
  `tipo_movimentacao` enum('entrada','saida') NOT NULL,
  `descricao_movimentacao` text NOT NULL,
  `valor_movimentacao` decimal(10,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_mes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao`
--

INSERT INTO `movimentacao` (`id_movimentacao`, `data_movimentacao`, `tipo_movimentacao`, `descricao_movimentacao`, `valor_movimentacao`, `id_categoria`, `id_mes`) VALUES
(49, '2024-09-13', 'saida', 'Mensalidade', 586.97, 17, 8),
(50, '2024-09-06', 'entrada', 'Meu salario caiu', 2000.00, 18, 8),
(51, '2024-10-07', 'entrada', 'Meu salario caiu', 2000.00, 18, 9),
(52, '2024-10-15', 'saida', 'Mensalidade da faculdade', 586.97, 17, 9),
(53, '2024-11-07', 'entrada', 'Meu salario caiu', 2000.00, 18, 10),
(54, '2024-11-15', 'saida', 'Mensalidade faculdade', 586.97, 17, 10),
(55, '2024-10-19', 'saida', 'Viagem', 413.03, 16, 9),
(56, '2024-10-25', 'saida', 'Conta do mês passado', 741.29, 18, 9),
(57, '2024-09-28', 'saida', 'Scarpan', 2154.32, 16, 8),
(58, '2024-10-28', 'saida', 'Parque aquatico', 258.71, 16, 9);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`id_mes`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_mes` (`id_mes`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `mes`
--
ALTER TABLE `mes`
  MODIFY `id_mes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `movimentacao_ibfk_2` FOREIGN KEY (`id_mes`) REFERENCES `mes` (`id_mes`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
