-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2024 às 17:26
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
-- Banco de dados: `baloja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `login_clientes`
--

CREATE TABLE `login_clientes` (
  `ID` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `login_clientes`
--

INSERT INTO `login_clientes` (`ID`, `nome`, `email`, `senha`, `is_admin`, `reset_token`, `token_expiration`, `verification_code`) VALUES
(4, NULL, 'admin@example.com', '$2y$10$cnKkzIo6qC5n3SFSXminZePAgLUS8k7sSpjDqgueb5r3IBEPk8vYa', 2, '1f0496b87a12f890790c0fa80a8ddbf4', '2024-09-15 20:11:02', '575221'),
(5, 'João Pedro Diniz Nacur', 'luisoujpof@gmail.com', '$2y$10$CMAN.fVK25o7OguNt7Wr9OfJ2BXEePxd7zNkDpY3dds8l0tLCBrX2', 0, NULL, NULL, '449467'),
(6, 'Gabriel ', '7stevensdiamante@gmail.com', '$2y$10$YOGlGSHrtO8zHgGMjhjFEu0qoqfWTBnTg.IZpGDahuclw9FN6Oi1S', 0, NULL, NULL, 'e7f00bf653ab');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `largura` decimal(10,2) DEFAULT NULL,
  `comprimento` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `foto4` varchar(255) DEFAULT NULL,
  `foto5` varchar(255) DEFAULT NULL,
  `foto6` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `altura`, `largura`, `comprimento`, `foto`, `foto2`, `foto3`, `foto4`, `foto5`, `foto6`) VALUES
(9, 'Lancheira retangular com desenhos', 'Transforme o momento do lanche em uma experiência divertida e única com nossa lancheira personalizada com desenhos exclusivos! Feita para destacar-se e encantar tanto as crianças quanto os adultos, esta lancheira combina funcionalidade e estilo em um só produto.\r\n\r\nCaracterísticas:\r\n\r\nDesign Exclusivo: Escolha entre uma variedade de desenhos personalizados para refletir a personalidade e os interesses de quem a usa. Desde personagens adoráveis até padrões vibrantes, nossas lancheiras trazem um toque único a cada refeição.\r\n\r\nMaterial Durável: Confeccionada em material resistente e fácil de limpar, a lancheira é projetada para suportar o uso diário e manter o conteúdo fresco e seguro.\r\n\r\nEspaçosa e Prática: Com compartimentos bem organizados, você terá espaço suficiente para armazenar lanches, frutas, bebidas e até uma pequena refeição. A lancheira possui um compartimento principal grande e uma rede interna para itens menores.\r\n\r\nAlças Confortáveis: As alças ajustáveis e acolchoadas garantem conforto ao carregar, tornando-a perfeita para levar ao trabalho, à escola ou em passeios.\r\n\r\nFechamento Seguro: O zíper de alta qualidade assegura que seus itens permaneçam no lugar, sem vazamentos ou acidentes.\r\n\r\nPersonalização: Envie seu desenho ou escolha um dos nossos modelos exclusivos para criar uma lancheira que é realmente sua. A impressão de alta definição garante que os detalhes sejam nítidos e duradouros.\r\n\r\nCom uma lancheira personalizada com desenhos, você não só tem um item prático para transportar suas refeições, mas também uma peça que reflete sua individualidade e estilo. Ideal para presentes, eventos especiais ou para adicionar um toque pessoal ao seu dia a dia.', 84.00, 0.00, 0.00, 0.00, '0dab1a4e-c941-465c-bc5b-630a81507f8d.jpg', '3a98f714-edf1-4056-9517-e01ccbe5ad9c.jpg', '3dfeaf53-268f-441f-9929-3f11c6a295b5.jpg', '991f3884-295b-49ea-9c07-43ee451bf0d4.jpg', NULL, NULL),
(10, 'Lancheira retangular com desenhos', 'Transforme o momento do lanche em uma experiência divertida e única com nossa lancheira personalizada com desenhos exclusivos! Feita para destacar-se e encantar tanto as crianças quanto os adultos, esta lancheira combina funcionalidade e estilo em um só produto.', 84.00, 0.00, 0.00, 0.00, '0dab1a4e-c941-465c-bc5b-630a81507f8d.jpg', '3a98f714-edf1-4056-9517-e01ccbe5ad9c.jpg', '5f732748-289f-43d8-af55-be93345b9b65.jpg', '991f3884-295b-49ea-9c07-43ee451bf0d4.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_categoria`
--

CREATE TABLE `produto_categoria` (
  `produto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `login_clientes`
--
ALTER TABLE `login_clientes`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto_categoria`
--
ALTER TABLE `produto_categoria`
  ADD PRIMARY KEY (`produto_id`,`categoria_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login_clientes`
--
ALTER TABLE `login_clientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `produto_categoria`
--
ALTER TABLE `produto_categoria`
  ADD CONSTRAINT `produto_categoria_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `produto_categoria_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
