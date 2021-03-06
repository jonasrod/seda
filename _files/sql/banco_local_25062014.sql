-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.12-log - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela sedaerotica.carrinho
CREATE TABLE IF NOT EXISTS `carrinho` (
  `carrinhoId` int(11) NOT NULL AUTO_INCREMENT,
  `mClienteId` int(11) NOT NULL,
  `presente` int(11) DEFAULT NULL,
  `mensagemPresente` text,
  `chaveSeguranca` varchar(45) DEFAULT NULL,
  `dtCadastro` datetime DEFAULT NULL,
  `dtAtualizacao` datetime DEFAULT NULL,
  PRIMARY KEY (`carrinhoId`,`mClienteId`),
  KEY `fk_carrinho_cliente1_idx` (`mClienteId`),
  CONSTRAINT `fk_carrinho_cliente1` FOREIGN KEY (`mClienteId`) REFERENCES `cliente` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


-- Copiando estrutura para tabela sedaerotica.carrinhoproduto
CREATE TABLE IF NOT EXISTS `carrinhoproduto` (
  `mCarrinhoId` int(11) NOT NULL,
  `mProdutoId` int(11) NOT NULL,
  `quantidade` varchar(45) DEFAULT NULL,
  `dtCadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`mCarrinhoId`,`mProdutoId`),
  KEY `fk_carrinhoProduto_produto1_idx` (`mProdutoId`),
  CONSTRAINT `fk_carrinhoProduto_carrinho1` FOREIGN KEY (`mCarrinhoId`) REFERENCES `carrinho` (`carrinhoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrinhoProduto_produto1` FOREIGN KEY (`mProdutoId`) REFERENCES `produto` (`produtoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando estrutura para tabela sedaerotica.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoriaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `dtCadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`categoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.categoria: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`categoriaId`, `descricao`, `dtCadastro`, `status`) VALUES
	(1, 'ACESSÓRIOS', '2014-06-25 09:43:42', 1),
	(2, 'BRINCADEIRAS', '2014-03-25 16:58:51', 1),
	(3, 'COSMETICOS', '2014-03-25 17:04:57', 1),
	(4, 'FANTASIAS', '2014-03-25 17:05:22', 1),
	(5, 'PENIS', '2014-03-25 17:05:39', 1),
	(6, 'SADO/FETICHE', '2014-03-25 17:05:51', 1),
	(7, 'VIBRADORES', '2014-03-25 17:06:28', 1),
	(8, 'LANGERIES', '2014-03-25 17:06:44', 1),
	(9, 'FILMES', '2014-03-25 17:07:23', 1),
	(10, 'DIVERSOS', '2014-03-25 17:07:35', 1),
	(11, 'BOTÃO', '2014-06-25 09:43:58', 1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `clienteId` int(11) NOT NULL AUTO_INCREMENT,
  `mGeneroId` int(11) NOT NULL,
  `mTipoClienteId` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `sobrenome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `dtAniversario` date DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `dtCadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `cpf` bigint(20) DEFAULT NULL,
  `rg` bigint(20) DEFAULT NULL,
  `telResidencial` bigint(20) DEFAULT NULL,
  `telComercial` bigint(20) DEFAULT NULL,
  `telCelular` bigint(20) DEFAULT NULL,
  `receberNovidades` int(11) DEFAULT '0',
  PRIMARY KEY (`clienteId`,`mGeneroId`,`mTipoClienteId`),
  KEY `fk_cliente_genero1_idx` (`mGeneroId`),
  KEY `fk_cliente_tipo_cliente1_idx` (`mTipoClienteId`),
  CONSTRAINT `fk_cliente_genero1` FOREIGN KEY (`mGeneroId`) REFERENCES `genero` (`generoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_tipo_cliente1` FOREIGN KEY (`mTipoClienteId`) REFERENCES `tipocliente` (`tipoClienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Copiando estrutura para tabela sedaerotica.embalagem
CREATE TABLE IF NOT EXISTS `embalagem` (
  `embalagemId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `altura` decimal(20,2) DEFAULT NULL,
  `largura` decimal(20,2) DEFAULT NULL,
  `comprimento` decimal(20,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `dtCadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`embalagemId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.embalagem: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `embalagem` DISABLE KEYS */;
INSERT INTO `embalagem` (`embalagemId`, `descricao`, `altura`, `largura`, `comprimento`, `status`, `dtCadastro`) VALUES
	(1, 'Embalagem 1', 12.00, 12.00, 12.00, 1, '2014-04-21 19:57:29');
/*!40000 ALTER TABLE `embalagem` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.endereco
CREATE TABLE IF NOT EXISTS `endereco` (
  `enderecoId` int(11) NOT NULL,
  `mClienteId` int(11) NOT NULL,
  `mTipoEnderecoId` int(11) NOT NULL,
  `mEstadoID` int(11) DEFAULT NULL,
  `cep` int(11) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `bairro` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `observacoes` text,
  PRIMARY KEY (`enderecoId`,`mClienteId`,`mTipoEnderecoId`),
  KEY `fk_endereco_cliente1_idx` (`mClienteId`),
  KEY `fk_endereco_tipo_endereco1_idx` (`mTipoEnderecoId`),
  KEY `FK_endereco_estado` (`mEstadoID`),
  CONSTRAINT `FK_endereco_estado` FOREIGN KEY (`mEstadoID`) REFERENCES `estado` (`estadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_cliente1` FOREIGN KEY (`mClienteId`) REFERENCES `cliente` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_tipo_endereco1` FOREIGN KEY (`mTipoEnderecoId`) REFERENCES `tipoendereco` (`tipoEnderecoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Copiando estrutura para tabela sedaerotica.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `estadoID` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` varchar(45) DEFAULT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`estadoID`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.estado: ~27 rows (aproximadamente)
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`estadoID`, `sigla`, `descricao`) VALUES
	(2, 'AC', 'Acre'),
	(3, 'AL', 'Alagoas'),
	(4, 'AP', 'Amapá'),
	(5, 'AM', 'Amazonas'),
	(6, 'BA', 'Bahia'),
	(7, 'CE', 'Ceará'),
	(8, 'DF', 'Distrito Federal'),
	(9, 'ES', 'Espírito Santo'),
	(10, 'GO', 'Goiás'),
	(11, 'MA', 'Maranhão'),
	(12, 'MT', 'Mato Grosso'),
	(13, 'MS', 'Mato Grosso do Sul'),
	(14, 'MG', 'Minas Gerais'),
	(15, 'PA', 'Pará'),
	(16, 'PB', 'Paraíba'),
	(17, 'PR', 'Paraná'),
	(18, 'PE', 'Pernambuco'),
	(19, 'PI', 'Piauí'),
	(20, 'RJ', 'Rio de Janeiro'),
	(21, 'RN', 'Rio Grande do Norte'),
	(22, 'RS', 'Rio Grande do Sul'),
	(23, 'RO', 'Rondônia'),
	(24, 'RR', 'Roraima'),
	(25, 'SP', 'São Paulo'),
	(26, 'SC', 'Santa Catarina'),
	(27, 'SE', 'Sergipe'),
	(28, 'TO', 'Tocantins');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.files
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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;


-- Copiando estrutura para tabela sedaerotica.genero
CREATE TABLE IF NOT EXISTS `genero` (
  `generoId` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`generoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.genero: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `genero` DISABLE KEYS */;
INSERT INTO `genero` (`generoId`, `descricao`, `status`) VALUES
	(1, 'Masculino', 1),
	(2, 'Feminino', 1);
/*!40000 ALTER TABLE `genero` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.login
CREATE TABLE IF NOT EXISTS `login` (
  `loginId` int(11) NOT NULL,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`loginId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.login: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`loginId`, `login`, `senha`, `status`) VALUES
	(0, 'admin', 'admin', 1);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `marcaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`marcaId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando estrutura para tabela sedaerotica.produto
CREATE TABLE IF NOT EXISTS `produto` (
  `produtoId` int(11) NOT NULL AUTO_INCREMENT,
  `mMarcaId` int(11) NOT NULL,
  `mSubcategoriaId` int(11) NOT NULL DEFAULT '0',
  `codigoProduto` varchar(45) DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `descricao` text,
  `dtCadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtAutualizacao` timestamp NULL DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `valor` float(4,2) DEFAULT NULL,
  `valorOriginal` float(4,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `quantidadeMinima` int(11) DEFAULT NULL,
  `peso` decimal(20,2) DEFAULT NULL,
  `destaque` int(11) DEFAULT NULL,
  `informacao` text,
  `desconto` float DEFAULT NULL,
  `flPromocao` int(11) DEFAULT '0',
  `flLancamento` int(11) DEFAULT '0',
  PRIMARY KEY (`produtoId`,`mMarcaId`,`mSubcategoriaId`),
  KEY `fk_produto_marca1_idx` (`mMarcaId`),
  KEY `fk_produto_subcategoria1_idx` (`mSubcategoriaId`),
  CONSTRAINT `fk_produto_marca1` FOREIGN KEY (`mMarcaId`) REFERENCES `marca` (`marcaId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_subcategoria1` FOREIGN KEY (`mSubcategoriaId`) REFERENCES `subcategoria` (`subcategoriaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


-- Copiando estrutura para tabela sedaerotica.produtosequence
CREATE TABLE IF NOT EXISTS `produtosequence` (
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `sequence_UNIQUE` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.produtosequence: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `produtosequence` DISABLE KEYS */;
INSERT INTO `produtosequence` (`sequence`) VALUES
	(13);
/*!40000 ALTER TABLE `produtosequence` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.subcategoria
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

-- Copiando dados para a tabela sedaerotica.subcategoria: ~56 rows (aproximadamente)
/*!40000 ALTER TABLE `subcategoria` DISABLE KEYS */;
INSERT INTO `subcategoria` (`subcategoriaId`, `descricao`, `dtCadastro`, `mCategoriaId`, `status`) VALUES
	(1, 'Femininos', '2014-03-26 12:30:59', 1, 1),
	(2, 'Masculinos', '2014-03-25 17:11:00', 1, 1),
	(3, 'Anéis Penianos', '2014-06-25 09:44:20', 1, 1),
	(4, 'Capas Penianas', '2014-03-25 17:12:45', 1, 1),
	(5, 'Cintas Penianas', '2014-03-25 17:13:10', 1, 1),
	(6, 'Duchas Higiênicas', '2014-06-25 09:44:38', 1, 1),
	(7, 'Estimuladores', '2014-03-25 17:14:07', 1, 1),
	(8, 'Pompoarismo', '2014-03-25 17:14:28', 1, 1),
	(9, 'Tapa Mamilos', '2014-03-25 17:14:52', 1, 1),
	(10, 'Diversos', '2014-03-25 17:15:12', 1, 1),
	(11, 'Baralhos', '2014-03-25 17:15:38', 2, 1),
	(12, 'Brincadeiras Eróticas', '2014-06-25 09:44:51', 2, 1),
	(13, 'Cartões Animados', '2014-06-25 09:45:07', 2, 1),
	(14, 'Velas Eróticas', '2014-06-25 09:45:28', 2, 1),
	(15, 'Diversos', '2014-03-26 14:18:39', 2, 1),
	(16, 'Bolinhas do Prazer', '2014-03-26 14:19:03', 3, 1),
	(17, 'Calcinha Comestível', '2014-06-25 09:45:47', 3, 1),
	(18, 'Gel Comestível', '2014-06-25 09:46:01', 3, 1),
	(19, 'Gel de Massagem', '2014-03-26 14:25:48', 3, 1),
	(20, 'Higienizador de Brinquedos', '2014-03-26 14:26:00', 3, 1),
	(21, 'Lubrificantes', '2014-03-26 14:29:44', 3, 1),
	(22, 'Perfumes Eróticos', '2014-06-25 09:46:15', 3, 1),
	(23, 'Retard e Prolong', '2014-03-26 14:30:31', 3, 1),
	(24, 'Sexo Oral', '2014-03-26 14:30:40', 3, 1),
	(25, 'Sexy Hot', '2014-03-26 14:31:18', 3, 1),
	(26, 'Velas Beijáveis', '2014-06-25 09:46:33', 3, 1),
	(27, 'Fantasias Femininas', '2014-03-26 16:59:49', 4, 1),
	(28, 'Fantasias Masculinas', '2014-03-26 17:19:40', 4, 1),
	(29, 'Meias Sensuais', '2014-03-26 17:19:58', 4, 1),
	(30, 'Diversos', '2014-03-26 17:20:15', 4, 1),
	(31, 'Pênis Duplo', '2014-06-25 09:46:50', 5, 1),
	(32, 'Pênis Realístico', '2014-06-25 09:47:13', 5, 1),
	(33, 'Pênis c/ vibro', '2014-06-25 09:47:29', 5, 1),
	(34, 'Pênis s/ vibro', '2014-06-25 09:47:40', 5, 1),
	(35, 'Algemas', '2014-03-26 17:23:14', 6, 1),
	(36, 'Chicote e Chibata', '2014-03-26 17:23:27', 6, 1),
	(37, 'Mordaça', '2014-06-25 09:47:52', 6, 1),
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
	(55, 'Bonecas Infláveis', '2014-06-25 09:48:22', 10, 1),
	(56, 'Outros', '2014-03-26 17:47:11', 10, 1);
/*!40000 ALTER TABLE `subcategoria` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.tipocliente
CREATE TABLE IF NOT EXISTS `tipocliente` (
  `tipoClienteId` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`tipoClienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.tipocliente: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipocliente` DISABLE KEYS */;
INSERT INTO `tipocliente` (`tipoClienteId`, `descricao`, `status`) VALUES
	(1, 'Fisica', 1),
	(2, 'Juridica', 1);
/*!40000 ALTER TABLE `tipocliente` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.tipoendereco
CREATE TABLE IF NOT EXISTS `tipoendereco` (
  `tipoEnderecoId` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`tipoEnderecoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.tipoendereco: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipoendereco` DISABLE KEYS */;
INSERT INTO `tipoendereco` (`tipoEnderecoId`, `descricao`, `status`) VALUES
	(1, 'Fatura', 1),
	(2, 'Entrega', 1);
/*!40000 ALTER TABLE `tipoendereco` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.tipopagamento
CREATE TABLE IF NOT EXISTS `tipopagamento` (
  `tipoPagamentoId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tipoPagamentoId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.tipopagamento: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `tipopagamento` DISABLE KEYS */;
INSERT INTO `tipopagamento` (`tipoPagamentoId`, `descricao`, `status`, `dtCadastro`) VALUES
	(1, 'Crédito', '1', '2014-04-21 21:20:57'),
	(2, 'Boleto', '1', '2014-04-21 21:35:09'),
	(3, 'Débito', '1', '2014-04-21 21:35:37');
/*!40000 ALTER TABLE `tipopagamento` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.venda
CREATE TABLE IF NOT EXISTS `venda` (
  `vendaId` int(11) NOT NULL AUTO_INCREMENT,
  `mCarrinhoId` int(11) NOT NULL,
  `mClienteId` int(11) NOT NULL,
  `mTipoPagamentoId` int(11) NOT NULL,
  `mEmbalagemId` int(11) NOT NULL,
  `referencia` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `valorTotalProduto` float DEFAULT NULL,
  `valorFrete` float DEFAULT NULL,
  `valorDesconto` float DEFAULT NULL,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`vendaId`,`mCarrinhoId`,`mClienteId`,`mTipoPagamentoId`,`mEmbalagemId`),
  KEY `fk_venda_carrinho1_idx` (`mCarrinhoId`,`mClienteId`),
  KEY `fk_venda_tipoPagamento1_idx` (`mTipoPagamentoId`),
  KEY `fk_venda_embalagem1_idx` (`mEmbalagemId`),
  CONSTRAINT `fk_venda_carrinho1` FOREIGN KEY (`mCarrinhoId`, `mClienteId`) REFERENCES `carrinho` (`carrinhoId`, `mClienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_embalagem1` FOREIGN KEY (`mEmbalagemId`) REFERENCES `embalagem` (`embalagemId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venda_tipoPagamento1` FOREIGN KEY (`mTipoPagamentoId`) REFERENCES `tipopagamento` (`tipoPagamentoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


-- Copiando estrutura para tabela sedaerotica.vendahistorico
CREATE TABLE IF NOT EXISTS `vendahistorico` (
  `vendaHistoricoId` int(11) NOT NULL AUTO_INCREMENT,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  `mVendaId` int(11) NOT NULL,
  PRIMARY KEY (`vendaHistoricoId`,`mVendaId`),
  KEY `fk_vendaHistorico_venda1_idx` (`mVendaId`),
  CONSTRAINT `fk_vendaHistorico_venda1` FOREIGN KEY (`mVendaId`) REFERENCES `venda` (`vendaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
