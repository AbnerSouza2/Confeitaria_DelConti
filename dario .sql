-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/05/2024 às 05:34
-- Versão do servidor: 11.3.2-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes_fiados`
--

CREATE TABLE `clientes_fiados` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `saldo_devedor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `clientes_fiados`
--

INSERT INTO `clientes_fiados` (`id`, `nome`, `telefone`, `saldo_devedor`) VALUES
(16, 'Abner de Souza', '19981344568', 95.80),
(17, 'Jose maria', '1185412563', 45.00),
(18, 'Marcela Ferreira', '1985426325', 112.00),
(19, 'jjjj', '1965656565', NULL),
(20, 'Abner de Souza', '19981344568', NULL),
(21, 'Abner de Souza', '19981344568', NULL),
(22, 'Carlos', '23213131321', 75.00),
(26, 'ABNER', '4334122133', NULL),
(30, 'sadasd', '3213123323', NULL),
(31, 'sadasd', '3213123323', NULL),
(32, 'sadasd', '3213123323', NULL),
(33, 'sadasd', '3213123323', NULL),
(34, 'ABNER', '41414141414', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas_fiscais`
--

CREATE TABLE `notas_fiscais` (
  `id` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `valor_nota` decimal(10,2) NOT NULL,
  `data_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `notas_fiscais`
--

INSERT INTO `notas_fiscais` (`id`, `empresa`, `valor_nota`, `data_hora`) VALUES
(23, 'mercado', 3232.00, '2024-05-20 20:11:35'),
(24, 'Sorveteria', 212.00, '2024-05-20 20:11:39'),
(26, 'tapouer', 34.00, '2024-05-20 21:52:11'),
(30, 'Sorveteria', 545.00, '2024-05-21 23:34:33'),
(31, 'Sorveteria', 500.00, '2024-05-22 00:05:17'),
(32, 'mercado', 1.00, '2024-05-22 00:25:26'),
(33, 'mercado', 5.00, '2024-05-22 00:25:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `valor`) VALUES
(20, 'Coxinha', 6.00),
(21, 'Refrigerante lata 200ml', 5.00),
(33, 'Pao', 0.80),
(35, 'Salgado Assado', 10.00),
(36, 'Bolo no pote', 13.50),
(37, 'Leite', 6.50),
(38, 'Pudim', 25.00),
(40, 'miojo', 3.20),
(41, 'Bombas', 2.92),
(105, 'lilil', 87.00),
(107, 'Coxinha', 77.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `data_hora` datetime DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `produto` varchar(255) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `tipo_pagamento` varchar(20) NOT NULL,
  `valor_un` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `id_cliente_fiado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id`, `data_hora`, `id_produto`, `produto`, `quantidade`, `tipo_pagamento`, `valor_un`, `valor_total`, `id_cliente_fiado`) VALUES
(7, '2024-05-01 20:53:10', 21, 'Refrigerante lata 200ml', 4, 'pix', 5.00, 20.00, NULL),
(8, '2024-05-01 20:54:32', 36, 'Bolo no pote', 1, 'dinheiro', 13.50, 13.50, NULL),
(9, '2024-05-01 20:55:34', 20, 'Coxinha', 1, 'pix', 5.50, 5.50, NULL),
(10, '2024-05-01 20:57:23', 20, 'Coxinha', 2, 'fiado', 5.50, 11.00, NULL),
(13, '2024-05-01 21:05:29', 33, 'Pao', 1, 'pix', 55.44, 55.44, NULL),
(14, '2024-05-01 21:07:02', 33, 'Pao', 1, 'pix', 55.44, 55.44, NULL),
(15, '2024-05-01 21:08:23', 33, 'Pao', 1, 'pix', 55.44, 55.44, NULL),
(16, '2024-05-01 21:08:39', 35, 'Salgado Assado', 1, 'pix', 10.00, 10.00, NULL),
(17, '2024-05-01 21:46:56', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(18, '2024-05-01 21:46:57', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(19, '2024-05-01 21:46:58', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(20, '2024-05-01 21:46:58', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(21, '2024-05-01 21:46:59', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(22, '2024-05-01 21:46:59', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(23, '2024-05-01 21:47:11', 21, 'Refrigerante lata 200ml', 5, 'cartao', 5.00, 25.00, NULL),
(24, '2024-05-01 21:47:49', 37, 'Leite', 1, 'pix', 500.00, 500.00, NULL),
(25, '2024-05-01 21:51:23', 35, 'Salgado Assado', 1, 'cartao', 10.00, 10.00, NULL),
(26, '2024-05-01 21:51:25', 35, 'Salgado Assado', 1, 'cartao', 10.00, 10.00, NULL),
(27, '2024-05-01 22:28:38', 38, 'Pudim', 1, 'pix', 25.00, 25.00, NULL),
(65, '2024-05-01 23:52:07', 40, 'miojo', 2, 'pix', 3.20, 6.40, NULL),
(66, '2024-05-02 00:00:35', 41, 'Bomba', 3, 'pix', 2.90, 8.70, NULL),
(67, '2024-05-02 00:07:27', 33, 'Pao', 10, 'fiado', 0.90, 9.00, NULL),
(68, '2024-05-04 15:49:01', 20, 'Coxinha', 1, 'pix', 5.50, 5.50, NULL),
(69, '2024-05-04 15:49:05', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, NULL),
(70, '2024-05-04 16:04:53', 21, 'Refrigerante lata 200ml', 2, 'dinheiro', 5.00, 10.00, NULL),
(71, '2024-05-04 16:06:50', 21, 'Refrigerante lata 200ml', 4, 'dinheiro', 5.00, 20.00, NULL),
(72, '2024-05-04 16:12:01', 21, 'Refrigerante lata 200ml', 3, 'dinheiro', 5.00, 15.00, NULL),
(73, '2024-05-04 16:12:04', 21, 'Refrigerante lata 200ml', 3, 'dinheiro', 5.00, 15.00, NULL),
(74, '2024-05-04 16:13:32', 36, 'Bolo no pote', 4, 'dinheiro', 13.50, 54.00, NULL),
(75, '2024-05-04 16:13:58', 33, 'Pao', 4, 'dinheiro', 0.80, 3.20, NULL),
(76, '2024-05-04 16:16:57', 37, 'Leite', 3, 'cartao', 6.50, 19.50, NULL),
(77, '2024-05-04 16:32:47', 35, 'Salgado Assado', 3, 'dinheiro', 10.00, 30.00, NULL),
(78, '2024-05-04 16:46:06', 35, 'Salgado Assado', 5, 'dinheiro', 10.00, 50.00, NULL),
(79, '2024-05-04 16:56:09', 35, 'Salgado Assado', 2, 'dinheiro', 10.00, 20.00, NULL),
(80, '2024-05-04 17:01:36', 21, 'Refrigerante lata 200ml', 3, 'dinheiro', 5.00, 15.00, NULL),
(81, '2024-05-04 17:02:39', 21, 'Refrigerante lata 200ml', 3, 'dinheiro', 5.00, 15.00, NULL),
(82, '2024-05-04 17:02:42', 21, 'Refrigerante lata 200ml', 3, 'dinheiro', 5.00, 15.00, NULL),
(83, '2024-05-04 17:02:49', 21, 'Refrigerante lata 200ml', 4, 'cartao', 5.00, 20.00, NULL),
(84, '2024-05-04 17:02:59', 20, 'Coxinha', 4, 'dinheiro', 5.50, 22.00, NULL),
(85, '2024-05-05 09:02:05', 20, 'Coxinha', 1, 'pix', 5.50, 5.50, NULL),
(86, '2024-05-05 09:02:21', 37, 'Leite', 3, 'cartao', 6.50, 19.50, NULL),
(87, '2024-05-05 09:04:41', 35, 'Salgado Assado', 2, 'dinheiro', 10.00, 20.00, NULL),
(88, '2024-05-05 09:04:51', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, NULL),
(89, '2024-05-05 09:46:28', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(90, '2024-05-05 09:49:39', 20, 'Coxinha', 3, 'cartao', 5.50, 16.50, NULL),
(91, '2024-05-05 09:49:47', 20, 'Coxinha', 3, 'dinheiro', 5.50, 16.50, NULL),
(92, '2024-05-05 10:07:21', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, 1),
(93, '2024-05-05 10:08:02', 33, 'Pao', 3, 'fiado', 0.80, 2.40, 14),
(94, '2024-05-05 10:10:45', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(95, '2024-05-05 10:11:41', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(96, '2024-05-05 10:17:35', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, NULL),
(97, '2024-05-05 10:20:50', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(98, '2024-05-05 10:25:28', 35, 'Salgado Assado', 2, 'fiado', 10.00, 20.00, NULL),
(99, '2024-05-05 10:27:16', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, NULL),
(100, '2024-05-05 10:29:10', 21, 'Refrigerante lata 200ml', 2, 'fiado', 5.00, 10.00, NULL),
(101, '2024-05-05 10:38:50', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(102, '2024-05-05 10:53:15', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, NULL),
(103, '2024-05-05 10:53:48', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, NULL),
(104, '2024-05-05 11:23:52', 35, 'Salgado Assado', 2, 'fiado', 10.00, 20.00, 1),
(105, '2024-05-05 11:25:18', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, 1),
(106, '2024-05-05 11:34:57', 35, 'Salgado Assado', 4, 'fiado', 10.00, 40.00, 15),
(107, '2024-05-05 11:36:52', 20, 'Coxinha', 1, 'fiado', 5.50, 5.50, 16),
(108, '2024-05-05 11:37:01', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, 17),
(109, '2024-05-05 11:37:09', 35, 'Salgado Assado', 10, 'fiado', 10.00, 100.00, 18),
(110, '2024-05-05 11:37:26', 35, 'Salgado Assado', 2, 'fiado', 10.00, 20.00, 16),
(111, '2024-05-05 19:38:25', 20, 'Coxinha', 2, 'fiado', 5.00, 10.00, 16),
(112, '2024-05-08 21:25:01', 20, 'Coxinha', 1, 'fiado', 6.00, 6.00, 16),
(113, '2024-05-08 21:25:05', 20, 'Coxinha', 1, 'dinheiro', 6.00, 6.00, 16),
(114, '2024-05-08 21:25:09', 20, 'Coxinha', 1, 'cartao', 6.00, 6.00, 16),
(115, '2024-05-08 21:25:12', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, 16),
(116, '2024-05-08 21:25:48', 21, 'Refrigerante lata 200ml', 1, 'fiado', 5.00, 5.00, 16),
(117, '2024-05-08 21:25:52', 21, 'Refrigerante lata 200ml', 1, 'dinheiro', 5.00, 5.00, 16),
(118, '2024-05-08 21:25:54', 21, 'Refrigerante lata 200ml', 1, 'cartao', 5.00, 5.00, 16),
(119, '2024-05-08 21:25:57', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, 16),
(120, '2024-05-08 21:26:02', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, 16),
(121, '2024-05-08 21:26:15', 20, 'Coxinha', 1, 'fiado', 6.00, 6.00, 16),
(122, '2024-05-08 21:26:17', 20, 'Coxinha', 1, 'dinheiro', 6.00, 6.00, 16),
(123, '2024-05-08 21:31:02', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 16),
(124, '2024-05-08 21:31:11', 35, 'Salgado Assado', 1, 'pix', 10.00, 10.00, 16),
(125, '2024-05-08 21:31:35', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 16),
(126, '2024-05-08 21:31:38', 35, 'Salgado Assado', 1, 'pix', 10.00, 10.00, 16),
(127, '2024-05-08 21:55:35', 33, 'Pao', 1, 'pix', 0.80, 0.80, NULL),
(128, '2024-05-08 21:57:33', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, NULL),
(129, '2024-05-08 21:57:37', 20, 'Coxinha', 1, 'cartao', 6.00, 6.00, NULL),
(130, '2024-05-08 21:57:53', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 16),
(131, '2024-05-08 21:58:06', 35, 'Salgado Assado', 1, 'dinheiro', 10.00, 10.00, NULL),
(132, '2024-05-08 21:58:18', 20, 'Coxinha', 2, 'fiado', 6.00, 12.00, 18),
(133, '2024-05-08 21:58:30', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 17),
(134, '2024-05-08 21:58:45', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 17),
(135, '2024-05-11 07:19:26', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, 22),
(136, '2024-05-14 19:26:49', 20, 'Coxinhaa', 3, 'dinheiro', 6.00, 18.00, NULL),
(137, '2024-05-14 21:39:44', 21, 'Refrigerante lata 200ml', 3, 'pix', 5.00, 15.00, NULL),
(138, '2024-05-14 21:41:17', 35, 'Salgado Assado', 4, 'fiado', 10.00, 40.00, 16),
(139, '2024-05-14 23:12:44', 20, 'Coxinha', 4, 'pix', 6.00, 24.00, NULL),
(140, '2024-05-14 23:17:25', 36, 'Bolo no pote', 2, 'cartao', 13.50, 27.00, NULL),
(141, '2024-05-14 23:17:31', 36, 'Bolo no pote', 2, 'cartao', 13.50, 27.00, NULL),
(143, '2024-05-20 20:13:02', 20, 'Coxinha', 1, 'fiado', 6.00, 6.00, 16),
(147, '2024-05-20 20:26:15', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, 0),
(148, '2024-05-20 20:26:26', 21, 'Refrigerante lata 200ml', 1, 'cartao', 5.00, 5.00, 0),
(149, '2024-05-20 20:26:36', 35, 'Salgado Assado', 1, 'dinheiro', 10.00, 10.00, 0),
(150, '2024-05-20 20:27:02', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, 22),
(151, '2024-05-20 21:52:25', 41, 'Bomba', 1, 'pix', 2.91, 2.91, 0),
(152, '2024-05-20 21:52:31', 40, 'miojo', 4, 'cartao', 3.20, 12.80, 0),
(153, '2024-05-20 21:52:47', 38, 'Pudim', 10, 'dinheiro', 25.00, 250.00, 0),
(154, '2024-05-20 21:52:56', 37, 'Leite', 1, 'fiado', 6.50, 6.50, 16),
(155, '2024-05-21 22:41:10', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, 0),
(156, '2024-05-21 23:18:27', 40, 'miojo', 2, 'pix', 3.20, 6.40, 0),
(157, '2024-05-21 23:18:33', 35, 'Salgado Assado', 1, 'cartao', 10.00, 10.00, 0),
(158, '2024-05-21 23:19:34', 20, 'Coxinha', 2, 'dinheiro', 6.00, 12.00, 0),
(159, '2024-05-21 23:20:01', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, 22),
(160, '2024-05-21 23:25:18', 21, 'Refrigerante lata 200ml', 1, 'dinheiro', 5.00, 5.00, 0),
(161, '2024-05-21 23:42:50', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, 0),
(162, '2024-05-21 23:43:20', 20, 'Coxinha', 2, 'pix', 6.00, 12.00, 0),
(163, '2024-05-22 00:05:07', 20, 'Coxinha', 1, 'pix', 6.00, 6.00, 0),
(164, '2024-05-22 00:32:26', 21, 'Refrigerante lata 200ml', 1, 'pix', 5.00, 5.00, 0),
(165, '2024-05-22 00:32:31', 33, 'Pao', 1, 'fiado', 0.80, 0.80, 16);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes_fiados`
--
ALTER TABLE `clientes_fiados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notas_fiscais`
--
ALTER TABLE `notas_fiscais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes_fiados`
--
ALTER TABLE `clientes_fiados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `notas_fiscais`
--
ALTER TABLE `notas_fiscais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
