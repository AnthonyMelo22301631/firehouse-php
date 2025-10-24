-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/10/2025 às 15:21
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
-- Banco de dados: `firehouse`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `colaborador_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `nota` int(11) NOT NULL CHECK (`nota` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaboracoes`
--

CREATE TABLE `colaboracoes` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `status` enum('pendente','aceita','recusada') DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `colaboradores`
--

CREATE TABLE `colaboradores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `especialidade` varchar(150) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `experiencia` int(11) DEFAULT 0,
  `nota_media` decimal(3,2) DEFAULT 0.00,
  `criado_em` datetime DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `local` varchar(150) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `servicos` text DEFAULT NULL,
  `servicos_encontrados` text DEFAULT NULL,
  `data_evento` date NOT NULL,
  `descricao` text DEFAULT NULL,
  `status_evento` enum('aberto','em_andamento','finalizado','cancelado') NOT NULL DEFAULT 'aberto',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `user_id`, `titulo`, `tipo`, `local`, `cidade`, `estado`, `servicos`, `servicos_encontrados`, `data_evento`, `descricao`, `status_evento`, `created_at`) VALUES
(6, 3, 'teste1', 'Aniversário', 'Centro de Convenções', 'Bataguassu', 'MS', 'Fotógrafo,Filmagem', 'Filmagem', '2025-01-09', 'oll', 'aberto', '2025-10-24 00:57:59'),
(7, 3, 'teste3', 'Chá de Panela', 'Salão de Festas', 'Atílio Vivácqua', 'ES', 'Churrasco,Banda Ao Vivo,Apresentador', 'Churrasco,Banda Ao Vivo,Apresentador', '2025-11-09', 'aa', 'finalizado', '2025-10-24 01:45:02');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos_servicos`
--

CREATE TABLE `eventos_servicos` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `colaborador_id` int(11) DEFAULT NULL,
  `servico_codigo` varchar(12) DEFAULT NULL,
  `data_vinculo` datetime DEFAULT current_timestamp(),
  `servico_id` int(11) NOT NULL,
  `status` enum('pendente','em_andamento','finalizado') DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos_servicos`
--

INSERT INTO `eventos_servicos` (`id`, `evento_id`, `colaborador_id`, `servico_codigo`, `data_vinculo`, `servico_id`, `status`, `created_at`) VALUES
(2, 6, 2, 'SRV-DE6C26', '2025-10-23 22:29:24', 2, 'pendente', '2025-10-24 01:29:24'),
(3, 7, 2, 'SRV-B73CF9', '2025-10-23 22:49:56', 4, 'pendente', '2025-10-24 01:49:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `codigo_servico` varchar(12) DEFAULT NULL,
  `status` enum('ativo','em_evento','inativo') DEFAULT 'ativo',
  `criado_em` datetime DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `codigo_servico`, `status`, `criado_em`, `user_id`, `nome`, `descricao`, `preco`, `created_at`) VALUES
(1, NULL, 'ativo', '2025-10-23 11:00:40', 2, 'Organização de Eventos', 'aa', 0.00, '2025-10-22 23:56:27'),
(2, 'SRV-DE6C26', 'em_evento', '2025-10-23 21:59:02', 2, 'Fotografia e Filmagem', 'lindao', 0.00, '2025-10-24 00:59:02'),
(3, 'SRV-77F83C', 'ativo', '2025-10-23 22:49:16', 2, 'Locação de Espaços', 'sila', 0.00, '2025-10-24 01:49:16'),
(4, 'SRV-B73CF9', 'em_evento', '2025-10-23 22:49:24', 2, 'Entretenimento e Shows', 'palaçao', 0.00, '2025-10-24 01:49:24'),
(5, 'SRV-017847', 'ativo', '2025-10-23 23:06:10', 2, '', 'aa', 0.00, '2025-10-24 02:06:10'),
(6, 'SRV-E4E4B4', 'ativo', '2025-10-23 23:12:11', 2, '', 'aa', 0.00, '2025-10-24 02:12:11'),
(7, 'SRV-2D2C11', 'ativo', '2025-10-23 23:13:54', 2, 'Apresentador', 'wq', 0.00, '2025-10-24 02:13:54');

--
-- Acionadores `servicos`
--
DELIMITER $$
CREATE TRIGGER `trg_gerar_codigo_servico` BEFORE INSERT ON `servicos` FOR EACH ROW BEGIN
  SET NEW.codigo_servico = CONCAT('SRV-', UPPER(SUBSTRING(MD5(RAND()), 1, 6)));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `contato` varchar(50) DEFAULT NULL,
  `is_colaborador` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `password_hash`, `estado`, `cidade`, `contato`, `is_colaborador`, `created_at`) VALUES
(2, 'Anthony', 'p@g.com', '$2y$10$2esWu/QHgDl1ni3/voEpMeRfY2WFtLf9HuJiZZq3QT/P.37x7EgDy', '12', 'Rio Branco', '31995942414', 1, '2025-10-22 22:00:54'),
(3, 'sss', 'p2@g.com', '$2y$10$wley8nklVPZiwiZbVsZ5eOLmHhq6GYSRA00cmOHP2q9iz8jtkXqEa', '27', 'Água Branca', '31995942414', 0, '2025-10-24 00:46:35');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `colaboracoes`
--
ALTER TABLE `colaboracoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colab_evento` (`evento_id`),
  ADD KEY `fk_colab_user` (`user_id`);

--
-- Índices de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_colaborador_user` (`user_id`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_user` (`user_id`);

--
-- Índices de tabela `eventos_servicos`
--
ALTER TABLE `eventos_servicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_evento_servico_servico` (`servico_id`),
  ADD KEY `fk_eventos_servicos_evento` (`evento_id`),
  ADD KEY `fk_eventos_servicos_user` (`colaborador_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_servico` (`codigo_servico`),
  ADD KEY `fk_servico_user` (`user_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `colaboracoes`
--
ALTER TABLE `colaboracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `eventos_servicos`
--
ALTER TABLE `eventos_servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `colaboracoes`
--
ALTER TABLE `colaboracoes`
  ADD CONSTRAINT `fk_colab_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_colab_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD CONSTRAINT `fk_colaborador_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_evento_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `eventos_servicos`
--
ALTER TABLE `eventos_servicos`
  ADD CONSTRAINT `fk_evento_servico_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evento_servico_servico` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventos_servicos_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`),
  ADD CONSTRAINT `fk_eventos_servicos_user` FOREIGN KEY (`colaborador_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `fk_servico_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
