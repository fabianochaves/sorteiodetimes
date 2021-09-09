-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Set-2021 às 18:06
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codegroup`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `confirmacoes`
--

CREATE TABLE `confirmacoes` (
  `id_confirmacao` int(11) NOT NULL,
  `partida_confirmacao` int(11) NOT NULL,
  `usuario_confirmacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais`
--

CREATE TABLE `locais` (
  `id_local` int(11) NOT NULL,
  `nome_local` varchar(150) NOT NULL,
  `status_local` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `locais`
--

INSERT INTO `locais` (`id_local`, `nome_local`, `status_local`) VALUES
(1, 'JR Soccer', 1),
(2, 'Ginásio Peri', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `tipo_menu` int(11) NOT NULL,
  `nome_menu` varchar(100) NOT NULL,
  `icone_menu` varchar(50) NOT NULL,
  `rotina_menu` varchar(25) NOT NULL,
  `menu_menu` int(11) NOT NULL,
  `status_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `menus`
--

INSERT INTO `menus` (`id_menu`, `tipo_menu`, `nome_menu`, `icone_menu`, `rotina_menu`, `menu_menu`, `status_menu`) VALUES
(1, 0, 'Cadastros do Sistema', 'metismenu-icon pe-7s-note', '', 0, 1),
(2, 1, 'Menu', 'fa fa-desktop', 'cadastro-menu', 1, 1),
(3, 0, 'Cadastros Gerais', 'metismenu-icon pe-7s-note', '', 0, 1),
(4, 1, 'Usuário', 'fa fa-user', 'cadastro-usuario', 1, 1),
(5, 0, 'Consultas', 'metismenu-icon pe-7s-notebook', '', 0, 1),
(6, 1, 'Usuários', 'fa fa-users', 'consulta-usuario', 5, 1),
(7, 1, 'Local', 'fa fa-map-marker', 'cadastro-local', 3, 1),
(8, 1, 'Nova Partida', 'fa fa-soccer-ball-o', 'cadastro-partida', 3, 1),
(9, 0, 'Sorteio', 'metismenu-icon pe-7s-more', '', 0, 1),
(10, 1, 'Realizar Sorteio', 'fa fa-sitemap', 'realizar-sorteio', 9, 1),
(11, 0, 'Confirmações', 'metismenu-icon pe-7s-check', '', 0, 1),
(12, 1, 'Confirmar Presença', 'fa fa-check', 'consulta-confirmacao', 11, 1),
(13, 1, 'Consulta Sorteios', 'fa fa-list', 'consulta-sorteios', 9, 1),
(14, 1, 'Menu', 'fa fa-list', 'consulta-menu', 5, 1),
(15, 1, 'Locais', 'fa fa-map-marker', 'consulta-locais', 5, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `partidas`
--

CREATE TABLE `partidas` (
  `id_partida` int(11) NOT NULL,
  `local_partida` int(11) NOT NULL,
  `jogadoresTime_partida` int(11) NOT NULL,
  `data_partida` date NOT NULL,
  `hora_partida` time NOT NULL,
  `sorteio_partida` int(11) NOT NULL DEFAULT '0',
  `status_partida` int(11) NOT NULL COMMENT '1 = Aberta para Confirmação, 2 = Encerrada e Pronta para sortear, 3 = Sorteio Realizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfis`
--

CREATE TABLE `perfis` (
  `id_perfil` int(11) NOT NULL,
  `nome_perfil` varchar(100) NOT NULL,
  `permissoes_perfil` varchar(500) NOT NULL,
  `status_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfis`
--

INSERT INTO `perfis` (`id_perfil`, `nome_perfil`, `permissoes_perfil`, `status_perfil`) VALUES
(1, 'Administrador', '1^2^3^4^5^6^7^8^9^10^11^12^13^14^15^16', 1),
(2, 'Jogador', '9^11^12^13', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sorteios`
--

CREATE TABLE `sorteios` (
  `id_sorteio` int(11) NOT NULL,
  `partida_sorteio` int(11) NOT NULL,
  `user_sorteio` int(11) NOT NULL,
  `datahora_sorteio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sorteio_distribuicao`
--

CREATE TABLE `sorteio_distribuicao` (
  `id_distribuicao` int(11) NOT NULL,
  `codSorteio_distribuicao` int(11) NOT NULL,
  `partida_distribuicao` int(11) NOT NULL,
  `jogador_distribuicao` int(11) NOT NULL,
  `goleiro_distribuicao` int(11) NOT NULL,
  `time_distribuicao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `nivel_usuario` int(11) NOT NULL,
  `goleiro_usuario` int(11) NOT NULL,
  `login_usuario` varchar(100) NOT NULL,
  `senha_usuario` varchar(100) NOT NULL,
  `perfil_usuario` int(11) NOT NULL,
  `telefone_usuario` varchar(20) NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `status_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome_usuario`, `nivel_usuario`, `goleiro_usuario`, `login_usuario`, `senha_usuario`, `perfil_usuario`, `telefone_usuario`, `email_usuario`, `status_usuario`) VALUES
(1, 'Usuário Admin', 3, 0, 'usuario.admin', '0cee84ff91333af3e2e5f8dab92720db', 1, '(47) 99928-7257', 'fabianochavesg@gmail.com', 1),
(2, 'José de Lima', 4, 0, 'jose.lima', '908e2ca76fe9889b13ea436fd06116f3', 2, '(47) 9257-8478', 'joselima@teste.com.br', 1),
(3, 'Fabio Gouveia', 4, 0, 'fabio.gouveia', '28cad307166ef9733ae1ab5e5aeb9a81', 2, '(47) 99955-8865', 'fabiogouveia@teste.com.br', 1),
(4, 'Ricardo Silva', 1, 1, 'ricardo.silva', 'f013dca6457947b8b05882ceb728e66f', 2, '(47) 9985-8585', 'ricardosilva@teste.com.br', 1),
(5, 'Luciano Melo', 2, 1, 'luciano.melo', 'fc8721fb8ab6f7255d0166bc19073157', 2, '(47) 92895-4848', 'lucianomelo@teste.com.br', 1),
(6, 'Gabriel Henrique', 5, 0, 'gabriel.henrique', '9a249790013dfd36c3125bb417eed5e4', 2, '(47) 9985-2477', 'gabriel.henrique@teste.com.br', 1),
(7, 'Jhonatan Guilherme', 3, 0, 'jhonatan.guilherme', 'e01854fa12fa61d5ba33ad3bada09385', 2, '(47) 98468-4384', 'jhonatan.guilherme@teste.com.br', 1),
(8, 'Gustavo Silveira', 2, 0, 'gustavo.silveira', 'feb327e62c895bed10f225afe08c3ce6', 2, '(47) 98585-6841', 'gustavo.silveira@teste.com.br', 1),
(9, 'Tiago Correia', 4, 0, 'tiago.correia', '156be4b67310184234bf47ec1434ab4d', 2, '(47) 9858-5263', 'tiago.correia@teste.com.br', 1),
(10, 'Jonas Mileno', 3, 1, 'jonas.mileno', '7f85e6640e13df6659a719c1eed47425', 2, '(47) 98742-5858', 'jonas.mileno@teste.com.br', 1),
(11, 'Everton Milbauer', 4, 0, 'everton.milbauer', '416b2be537158b9e090e9cdb0e3f8e61', 2, '(47) 98855-3326', 'everton.milbauer@teste.com.br', 1),
(12, 'Luiz Santos', 5, 0, 'luiz.santos', '1f45bb024533b4832e6603b57af002d1', 2, '(47) 9965-5852', 'luiz.santos@teste.com.br', 1),
(13, 'João Guilherme', 4, 0, 'joao.guilherme', '598e2f50b320af37c3dc2bb819c3e694', 2, '(47) 99257-8895', 'joaoguilherme@teste.com.br', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `confirmacoes`
--
ALTER TABLE `confirmacoes`
  ADD PRIMARY KEY (`id_confirmacao`);

--
-- Indexes for table `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id_local`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id_partida`);

--
-- Indexes for table `perfis`
--
ALTER TABLE `perfis`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indexes for table `sorteios`
--
ALTER TABLE `sorteios`
  ADD PRIMARY KEY (`id_sorteio`);

--
-- Indexes for table `sorteio_distribuicao`
--
ALTER TABLE `sorteio_distribuicao`
  ADD PRIMARY KEY (`id_distribuicao`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `confirmacoes`
--
ALTER TABLE `confirmacoes`
  MODIFY `id_confirmacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locais`
--
ALTER TABLE `locais`
  MODIFY `id_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perfis`
--
ALTER TABLE `perfis`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sorteios`
--
ALTER TABLE `sorteios`
  MODIFY `id_sorteio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sorteio_distribuicao`
--
ALTER TABLE `sorteio_distribuicao`
  MODIFY `id_distribuicao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
