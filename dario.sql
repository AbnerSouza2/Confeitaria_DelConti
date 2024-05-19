-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20/05/2024 às 00:00
-- Versão do servidor: 10.4.28-MariaDB
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
(46, 'Abner de Souza', '19981344566', 20.20);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas`
--

CREATE TABLE `notas` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notas_fiscais`
--

CREATE TABLE `notas_fiscais` (
  `id` int(11) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `valor_nota` decimal(10,2) NOT NULL,
  `data_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notas_fiscais`
--

INSERT INTO `notas_fiscais` (`id`, `empresa`, `valor_nota`, `data_hora`) VALUES
(2, 'Sorveteria', 3212.00, '2024-05-19 18:53:49'),
(3, 'Mercado', 500.00, '2024-05-19 18:58:57'),
(4, 'tapouer', 1500.00, '2024-05-19 18:59:18');

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
(20, 'Coxinha', 5.50),
(21, 'Refrigerante lata 200ml', 5.00),
(33, 'Pao', 0.80),
(35, 'Salgado Assado', 10.00),
(36, 'Bolo no pote', 13.50),
(37, 'Leite', 6.50),
(38, 'Pudim', 25.00),
(39, 'Bolo de Chocolate', 15.99),
(40, 'miojo', 3.20),
(41, 'Bomba5', 2.95),
(42, 'cocada', 2.90);

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
(90, '2024-05-05 09:49:39', 20, 'Coxinha', 3, 'cartao', 5.50, 16.50, NULL),
(91, '2024-05-05 09:49:47', 20, 'Coxinha', 3, 'dinheiro', 5.50, 16.50, NULL),
(104, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(105, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(106, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(107, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(108, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(109, NULL, 20, NULL, 2, 'pix', 0.00, 11.00, 0),
(110, NULL, 20, NULL, 3, 'pix', 0.00, 16.50, 0),
(111, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(112, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(113, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(114, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(115, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(119, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(120, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(121, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(122, NULL, 21, NULL, 1, 'pix', 0.00, 5.00, 0),
(123, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(124, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(125, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(126, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(127, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(128, NULL, 33, NULL, 1, 'pix', 0.00, 0.80, 0),
(129, NULL, 33, NULL, 1, 'pix', 0.00, 0.80, 0),
(130, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(131, NULL, 20, NULL, 1, 'pix', 0.00, 5.50, 0),
(132, NULL, 42, NULL, 1, 'pix', 0.00, 2.90, 0),
(133, NULL, 21, NULL, 3, 'pix', 0.00, 15.00, 0),
(134, NULL, 33, NULL, 1, 'pix', 0.00, 0.80, 0),
(137, '2024-05-19 07:43:45', 33, 'Pao', 1, 'pix', 0.80, 0.80, 0),
(138, '2024-05-19 07:44:07', 35, 'Salgado Assado', 1, 'cartao', 10.00, 10.00, 0),
(141, '2024-05-19 07:49:19', 42, 'cocada', 1, 'pix', 2.90, 2.90, 0),
(147, '2024-05-19 15:07:33', 20, 'Coxinha', 1, 'pix', 5.50, 5.50, 0),
(161, '2024-05-19 15:38:49', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 34),
(165, '2024-05-19 15:45:56', 33, 'Pao', 1, 'fiado', 0.80, 0.80, 34),
(166, '2024-05-19 15:46:13', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 34),
(171, '2024-05-19 15:54:45', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 34),
(172, '2024-05-19 15:55:19', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 37),
(173, '2024-05-19 16:00:17', 38, 'Pudim', 1, 'fiado', 25.00, 25.00, 37),
(174, '2024-05-19 16:00:57', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 37),
(175, '2024-05-19 16:04:10', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 38),
(176, '2024-05-19 16:08:47', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 39),
(177, '2024-05-19 16:09:19', 38, 'Pudim', 2, 'fiado', 25.00, 50.00, 39),
(178, '2024-05-19 16:10:16', 20, 'Coxinha', 2, 'fiado', 5.50, 11.00, 39),
(179, '2024-05-19 16:11:34', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 40),
(180, '2024-05-19 16:12:29', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 41),
(181, '2024-05-19 16:14:46', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 42),
(182, '2024-05-19 16:16:02', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 43),
(184, '2024-05-19 16:25:27', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 44),
(185, '2024-05-19 16:25:48', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 44),
(186, '2024-05-19 16:26:34', 38, 'Pudim', 20, 'fiado', 25.00, 500.00, 45),
(187, '2024-05-19 16:26:59', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 45),
(188, '2024-05-19 18:12:09', 35, 'Salgado Assado', 10, 'fiado', 10.00, 100.00, 44),
(189, '2024-05-19 18:16:06', 35, 'Salgado Assado', 2, 'fiado', 10.00, 20.00, 46),
(190, '2024-05-19 18:40:03', 35, 'Salgado Assado', 1, 'fiado', 10.00, 10.00, 46);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes_fiados`
--
ALTER TABLE `clientes_fiados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notas`
--
ALTER TABLE `notas`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notas_fiscais`
--
ALTER TABLE `notas_fiscais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

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
