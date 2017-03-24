-- --------------------------------------------------------
-- Servidor:                     186.202.152.128
-- Versão do servidor:           5.1.71-rel14.9-log - (Percona Server (GPL), 14.9)
-- OS do Servidor:               debian-linux-gnu
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela site1386784179.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoriaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `dtCadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`categoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.categoria: ~10 rows (aproximadamente)
DELETE FROM `categoria`;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`categoriaId`, `descricao`, `dtCadastro`, `status`) VALUES
	(1, 'ACESSORIOS', '2014-04-03 17:26:07', 1),
	(2, 'BRINCADEIRAS', '2014-03-25 16:58:51', 1),
	(3, 'COSMETICOS', '2014-03-25 17:04:57', 1),
	(4, 'FANTASIAS', '2014-03-25 17:05:22', 1),
	(5, 'PENIS', '2014-03-25 17:05:39', 1),
	(6, 'SADO/FETICHE', '2014-03-25 17:05:51', 1),
	(7, 'VIBRADORES', '2014-03-25 17:06:28', 1),
	(8, 'LANGERIES', '2014-03-25 17:06:44', 1),
	(9, 'FILMES', '2014-03-25 17:07:23', 1),
	(10, 'DIVERSOS', '2014-03-25 17:07:35', 1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;


-- Copiando estrutura para tabela site1386784179.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `marcaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`marcaId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.marca: ~4 rows (aproximadamente)
DELETE FROM `marca`;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` (`marcaId`, `descricao`, `dtCadastro`, `status`) VALUES
	(1, 'MARCATESTE', NULL, 1),
	(2, 'ADÃO E EVA', NULL, 1),
	(3, 'INTT', NULL, 1),
	(4, 'FETICHE', NULL, 1);
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;


-- Copiando estrutura para tabela site1386784179.subcategoria
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `subcategoriaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `dtCadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mCategoriaId` int(11) NOT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`subcategoriaId`,`mCategoriaId`),
  KEY `fk_subcategoria_categoria_idx` (`mCategoriaId`),
  CONSTRAINT `fk_subcategoria_categoria` FOREIGN KEY (`mCategoriaId`) REFERENCES `categoria` (`categoriaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.subcategoria: ~56 rows (aproximadamente)
DELETE FROM `subcategoria`;
/*!40000 ALTER TABLE `subcategoria` DISABLE KEYS */;
INSERT INTO `subcategoria` (`subcategoriaId`, `descricao`, `dtCadastro`, `mCategoriaId`, `status`) VALUES
	(1, 'Femininos', '2014-03-26 12:30:59', 1, 1),
	(2, 'Masculinos', '2014-03-25 17:11:00', 1, 1),
	(3, 'Anéis Penianos', '2014-03-25 17:11:20', 1, 1),
	(4, 'Capas Penianas', '2014-03-25 17:12:45', 1, 1),
	(5, 'Cintas Penianas', '2014-03-25 17:13:10', 1, 1),
	(6, 'Duchas Higiênicas', '2014-03-25 17:13:51', 1, 1),
	(7, 'Estimuladores', '2014-03-25 17:14:07', 1, 1),
	(8, 'Pompoarismo', '2014-03-25 17:14:28', 1, 1),
	(9, 'Tapa Mamilos', '2014-03-25 17:14:52', 1, 1),
	(10, 'Diversos', '2014-03-25 17:15:12', 1, 1),
	(11, 'Baralhos', '2014-03-25 17:15:38', 2, 1),
	(12, 'Brincadeiras Eróticas', '2014-03-25 17:16:13', 2, 1),
	(13, 'Cartões Animados', '2014-03-25 17:16:26', 2, 1),
	(14, 'Velas Eróticas', '2014-03-25 17:16:58', 2, 1),
	(15, 'Diversos', '2014-03-26 14:18:39', 2, 1),
	(16, 'Bolinhas do Prazer', '2014-03-26 14:19:03', 3, 1),
	(17, 'Calcinha Comestível', '2014-03-26 14:19:18', 3, 1),
	(18, 'Gel Comestível', '2014-03-26 14:25:31', 3, 1),
	(19, 'Gel de Massagem', '2014-03-26 14:25:48', 3, 1),
	(20, 'Higienizador de Brinquedos', '2014-03-26 14:26:00', 3, 1),
	(21, 'Lubrificantes', '2014-03-26 14:29:44', 3, 1),
	(22, 'Perfumes Eróticos', '2014-03-26 14:30:07', 3, 1),
	(23, 'Retard e Prolong', '2014-03-26 14:30:31', 3, 1),
	(24, 'Sexo Oral', '2014-03-26 14:30:40', 3, 1),
	(25, 'Sexy Hot', '2014-03-26 14:31:18', 3, 1),
	(26, 'Velas Beijáveis', '2014-03-26 14:32:24', 3, 1),
	(27, 'Fantasias Femininas', '2014-03-26 16:59:49', 4, 1),
	(28, 'Fantasias Masculinas', '2014-03-26 17:19:40', 4, 1),
	(29, 'Meias Sensuais', '2014-03-26 17:19:58', 4, 1),
	(30, 'Diversos', '2014-03-26 17:20:15', 4, 1),
	(31, 'Pênis Duplo', '2014-03-26 17:21:48', 5, 1),
	(32, 'Pênis Realístico', '2014-03-26 17:22:03', 5, 1),
	(33, 'Pênis c/ vibro', '2014-03-26 17:22:18', 5, 1),
	(34, 'Pênis s/ vibro', '2014-03-26 17:22:49', 5, 1),
	(35, 'Algemas', '2014-03-26 17:23:14', 6, 1),
	(36, 'Chicote e Chibata', '2014-03-26 17:23:27', 6, 1),
	(37, 'Mordaça', '2014-03-26 17:25:41', 6, 1),
	(38, 'Terapia Choque', '2014-03-26 17:26:00', 6, 1),
	(39, 'Diversos', '2014-03-26 17:26:16', 6, 1),
	(40, 'Ponto "G"', '2014-03-26 17:28:12', 7, 1),
	(41, 'Rotativo', '2014-03-26 17:31:01', 7, 1),
	(42, 'Massageadores', '2014-03-26 17:31:21', 7, 1),
	(43, 'Baby Doll', '2014-03-26 17:32:32', 8, 1),
	(44, 'Body', '2014-03-26 17:33:05', 8, 1),
	(45, 'Conjuntos', '2014-03-26 17:34:03', 8, 1),
	(46, 'Corset', '2014-03-26 17:34:24', 8, 1),
	(47, 'Cuecas', '2014-03-26 17:34:57', 8, 1),
	(48, 'Espartilhos', '2014-03-26 17:35:07', 8, 1),
	(49, 'Meias  ', '2014-03-26 17:39:39', 8, 1),
	(50, 'Tangas', '2014-03-26 17:40:25', 8, 1),
	(51, 'Diversos', '2014-03-26 17:40:37', 8, 1),
	(52, 'Livros', '2014-03-26 17:45:08', 10, 1),
	(53, 'Preservativos', '2014-03-26 17:45:41', 10, 1),
	(54, 'Pilhas', '2014-03-26 17:46:43', 10, 1),
	(55, 'Bonecas Infláveis', '2014-03-26 17:46:58', 10, 1),
	(56, 'Outros', '2014-03-26 17:47:11', 10, 1);
/*!40000 ALTER TABLE `subcategoria` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
