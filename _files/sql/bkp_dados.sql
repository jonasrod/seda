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


-- Copiando estrutura para tabela site1386784179.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `mProdutoId` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.files: ~7 rows (aproximadamente)
DELETE FROM `files`;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`id`, `name`, `size`, `type`, `url`, `title`, `description`, `mProdutoId`) VALUES
	(15, 'Jellyfish.jpg', 775702, 'image/jpeg', NULL, NULL, NULL, 1),
	(25, 'Lighthouse.jpg', 561276, 'image/jpeg', NULL, NULL, NULL, 2),
	(26, 'Tulips.jpg', 620888, 'image/jpeg', NULL, NULL, NULL, 2),
	(27, 'Koala.jpg', 780831, 'image/jpeg', NULL, NULL, NULL, 2),
	(28, 'Penguins.jpg', 777835, 'image/jpeg', NULL, NULL, NULL, 2),
	(50, 'product-l1.jpg', 420043, 'image/jpeg', NULL, NULL, NULL, 9),
	(53, 'product-3.jpg', 458935, 'image/jpeg', NULL, NULL, NULL, 10);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;


-- Copiando estrutura para tabela site1386784179.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `produtoId` int(11) NOT NULL AUTO_INCREMENT,
  `mMarcaId` int(11) NOT NULL,
  `mSubcategoriaId` int(11) NOT NULL DEFAULT '0',
  `codigoProduto` varchar(45) DEFAULT NULL,
  `descricao` text,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `valor` float DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `quantidadeMinima` int(11) DEFAULT NULL,
  `peso` decimal(20,2) DEFAULT NULL,
  `destaque` int(11) DEFAULT NULL,
  `informacao` text,
  `desconto` float DEFAULT NULL,
  PRIMARY KEY (`produtoId`,`mMarcaId`,`mSubcategoriaId`),
  KEY `fk_produto_marca1_idx` (`mMarcaId`),
  KEY `fk_produto_subcategoria1_idx` (`mSubcategoriaId`),
  CONSTRAINT `fk_produto_marca1` FOREIGN KEY (`mMarcaId`) REFERENCES `marca` (`marcaId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_subcategoria1` FOREIGN KEY (`mSubcategoriaId`) REFERENCES `subcategoria` (`subcategoriaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.produto: ~7 rows (aproximadamente)
DELETE FROM `produto`;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`produtoId`, `mMarcaId`, `mSubcategoriaId`, `codigoProduto`, `descricao`, `dtCadastro`, `status`, `valor`, `quantidade`, `quantidadeMinima`, `peso`, `destaque`, `informacao`, `desconto`) VALUES
	(4, 2, 12, '23BC001', 'Cartão - Vivo Arranhado', NULL, 1, 2.13, 3, 5, 0.00, 1, 'Cartão - Vivo Arranhado... mas não largo minha gata!', 500),
	(4, 4, 35, '32LS999', 'Algema', NULL, 1, 30, 3, 1, 200.00, 1, 'Algema Fetiche Tigrada', 500),
	(5, 2, 13, '23BC014', 'Cartão - Vou te dar umas aulinhas....', NULL, 1, 2.2, 3, 1, 0.00, 1, 'OH, YES! OH, GOD! I LOVE! YES! FUCK! YES!', 500),
	(7, 1, 41, '123', 'Teste 1', NULL, 1, 12.34, 10, 5, 1.00, NULL, 'Teste', 200),
	(8, 1, 2, '6666', 'Descrição...', NULL, 1, 40, 5, 2, 200.00, 1, 'Perfume', 5),
	(8, 1, 56, '321', 'TEste 2', NULL, 1, 12.33, 20, 2, 13.00, NULL, 'teste 2', 122),
	(9, 1, 2, '7777', 'Produto abaixo estoque min. ai aparece aqui.', NULL, 1, 100, 1, 5, 15.00, 1, 'Teste teste teste', 5);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;


-- Copiando estrutura para tabela site1386784179.produtosequence
CREATE TABLE IF NOT EXISTS `produtosequence` (
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `sequence_UNIQUE` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela site1386784179.produtosequence: ~1 rows (aproximadamente)
DELETE FROM `produtosequence`;
/*!40000 ALTER TABLE `produtosequence` DISABLE KEYS */;
INSERT INTO `produtosequence` (`sequence`) VALUES
	(11);
/*!40000 ALTER TABLE `produtosequence` ENABLE KEYS */;


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
