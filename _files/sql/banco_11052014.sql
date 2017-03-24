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

-- Copiando estrutura do banco de dados para sedaerotica
CREATE DATABASE IF NOT EXISTS `sedaerotica` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sedaerotica`;


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

-- Copiando dados para a tabela sedaerotica.carrinho: ~4 rows (aproximadamente)
DELETE FROM `carrinho`;
/*!40000 ALTER TABLE `carrinho` DISABLE KEYS */;
INSERT INTO `carrinho` (`carrinhoId`, `mClienteId`, `presente`, `mensagemPresente`, `chaveSeguranca`, `dtCadastro`, `dtAtualizacao`) VALUES
	(1, 1, NULL, '', '1265372513127635', '2014-04-21 19:53:39', '2014-04-21 19:53:40'),
	(2, 2, NULL, NULL, 'sadasdsadas', '2014-04-21 21:35:56', '2014-04-21 21:35:57'),
	(3, 2, NULL, NULL, '21321312', '2014-04-21 21:53:52', '2014-04-21 21:53:52'),
	(4, 1, NULL, NULL, '12', '2014-04-21 21:56:14', '2014-04-21 21:56:15');
/*!40000 ALTER TABLE `carrinho` ENABLE KEYS */;


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

-- Copiando dados para a tabela sedaerotica.carrinhoproduto: ~5 rows (aproximadamente)
DELETE FROM `carrinhoproduto`;
/*!40000 ALTER TABLE `carrinhoproduto` DISABLE KEYS */;
INSERT INTO `carrinhoproduto` (`mCarrinhoId`, `mProdutoId`, `quantidade`, `dtCadastro`) VALUES
	(1, 4, '4', '2014-04-21 19:54:56'),
	(2, 5, '1', '2014-04-21 21:36:17'),
	(3, 4, '1', '2014-04-21 21:54:50'),
	(3, 6, '3', '2014-04-21 21:54:18'),
	(4, 6, '3', '2014-04-21 21:56:55');
/*!40000 ALTER TABLE `carrinhoproduto` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `categoriaId` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `dtCadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`categoriaId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.categoria: ~3 rows (aproximadamente)
DELETE FROM `categoria`;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`categoriaId`, `descricao`, `dtCadastro`, `status`) VALUES
	(1, 'Masculino', '2014-02-24 00:42:45', 1),
	(2, 'Feminino', '2014-02-24 00:42:57', 1),
	(3, 'Categoria 1', '2014-03-25 00:21:44', 1);
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
  `dtCadastro` timestamp NULL DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.cliente: ~2 rows (aproximadamente)
DELETE FROM `cliente`;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` (`clienteId`, `mGeneroId`, `mTipoClienteId`, `nome`, `sobrenome`, `email`, `senha`, `dtAniversario`, `status`, `dtCadastro`, `cpf`, `rg`, `telResidencial`, `telComercial`, `telCelular`, `receberNovidades`) VALUES
	(1, 1, 1, 'João', 'da Silva', 'joao@gmail.com', '12345', '1984-04-08', 1, '2014-04-08 23:43:03', 99999999999, 999999999, 9999999999, 9999999999, 99999999999, 1),
	(2, 2, 1, 'Maria', 'das Dores', 'maria@gmail.com', '123', '1990-04-08', 1, '2014-04-08 23:45:01', 88888888888, 888888888, 8888888888, 8888888888, 88888888888, 0);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;


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

-- Copiando dados para a tabela sedaerotica.embalagem: ~1 rows (aproximadamente)
DELETE FROM `embalagem`;
/*!40000 ALTER TABLE `embalagem` DISABLE KEYS */;
INSERT INTO `embalagem` (`embalagemId`, `descricao`, `altura`, `largura`, `comprimento`, `status`, `dtCadastro`) VALUES
	(1, 'Embalagem 1', 12.00, 12.00, 12.00, 1, '2014-04-21 19:57:29');
/*!40000 ALTER TABLE `embalagem` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.endereco
CREATE TABLE IF NOT EXISTS `endereco` (
  `enderecoId` int(11) NOT NULL,
  `mClienteId` int(11) NOT NULL,
  `mTipoEnderecoId` int(11) NOT NULL,
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
  CONSTRAINT `fk_endereco_cliente1` FOREIGN KEY (`mClienteId`) REFERENCES `cliente` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_tipo_endereco1` FOREIGN KEY (`mTipoEnderecoId`) REFERENCES `tipoendereco` (`tipoEnderecoId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.endereco: ~2 rows (aproximadamente)
DELETE FROM `endereco`;
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
INSERT INTO `endereco` (`enderecoId`, `mClienteId`, `mTipoEnderecoId`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `observacoes`) VALUES
	(0, 2, 2, 9999999, 'Rua ABC', '312', 'ap 27 bl B', 'Parque Marajoara', 'Santo André', 'SP', 'próximo ao ragazzo'),
	(1, 1, 2, 9112000, 'R. Teste', '123', NULL, 'Teste', 'São Paulo', 'SP', 'teste');
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.genero
CREATE TABLE IF NOT EXISTS `genero` (
  `generoId` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`generoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.genero: ~2 rows (aproximadamente)
DELETE FROM `genero`;
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

-- Copiando dados para a tabela sedaerotica.login: ~1 rows (aproximadamente)
DELETE FROM `login`;
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

-- Copiando dados para a tabela sedaerotica.marca: ~2 rows (aproximadamente)
DELETE FROM `marca`;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` (`marcaId`, `descricao`, `dtCadastro`, `status`) VALUES
	(1, 'Marca_1', '2014-03-25 01:29:19', 1),
	(2, 'Marca 2', NULL, 1);
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.produto
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.produto: ~3 rows (aproximadamente)
DELETE FROM `produto`;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` (`produtoId`, `mMarcaId`, `mSubcategoriaId`, `codigoProduto`, `descricao`, `dtCadastro`, `status`, `valor`, `quantidade`, `quantidadeMinima`, `peso`, `destaque`, `informacao`, `desconto`) VALUES
	(4, 1, 1, '123', 'Teste', NULL, 1, 232.32, 10, 10, 12.00, 1, 'Teste', 111),
	(5, 2, 2, '312', 'Novo teste', NULL, 1, 22.22, 5, 5, 12.00, 1, 'teste', 1234),
	(6, 1, 2, 'adsda', 'qwewqewq', NULL, 1, 22.22, 23, 5, 2.00, NULL, '22222', 222);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.produtosequence
CREATE TABLE IF NOT EXISTS `produtosequence` (
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `sequence_UNIQUE` (`sequence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.produtosequence: ~1 rows (aproximadamente)
DELETE FROM `produtosequence`;
/*!40000 ALTER TABLE `produtosequence` DISABLE KEYS */;
INSERT INTO `produtosequence` (`sequence`) VALUES
	(7);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.subcategoria: ~2 rows (aproximadamente)
DELETE FROM `subcategoria`;
/*!40000 ALTER TABLE `subcategoria` DISABLE KEYS */;
INSERT INTO `subcategoria` (`subcategoriaId`, `descricao`, `dtCadastro`, `mCategoriaId`, `status`) VALUES
	(1, 'Teste 1_1', '2014-03-25 01:08:40', 3, 1),
	(2, 'Teste_1_2', '2014-03-31 22:50:46', 3, 1);
/*!40000 ALTER TABLE `subcategoria` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.tipocliente
CREATE TABLE IF NOT EXISTS `tipocliente` (
  `tipoClienteId` int(11) NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`tipoClienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.tipocliente: ~2 rows (aproximadamente)
DELETE FROM `tipocliente`;
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
DELETE FROM `tipoendereco`;
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
DELETE FROM `tipopagamento`;
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

-- Copiando dados para a tabela sedaerotica.venda: ~4 rows (aproximadamente)
DELETE FROM `venda`;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` (`vendaId`, `mCarrinhoId`, `mClienteId`, `mTipoPagamentoId`, `mEmbalagemId`, `referencia`, `status`, `valorTotalProduto`, `valorFrete`, `valorDesconto`, `dtCadastro`) VALUES
	(2, 1, 1, 1, 1, '12', 3, 122, 12, 5, '2014-04-21 21:26:19'),
	(4, 2, 2, 3, 1, '12', 3, 122, 11, 1, '2014-04-21 21:36:57'),
	(5, 3, 2, 2, 1, '12', 3, 11, 1, 1, '2014-04-21 21:55:51'),
	(7, 4, 1, 2, 1, '1', 2, 1, 1, 1, '2014-04-21 22:00:04');
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;


-- Copiando estrutura para tabela sedaerotica.vendahistorico
CREATE TABLE IF NOT EXISTS `vendahistorico` (
  `vendaHistoricoId` int(11) NOT NULL AUTO_INCREMENT,
  `dtCadastro` timestamp NULL DEFAULT NULL,
  `mVendaId` int(11) NOT NULL,
  PRIMARY KEY (`vendaHistoricoId`,`mVendaId`),
  KEY `fk_vendaHistorico_venda1_idx` (`mVendaId`),
  CONSTRAINT `fk_vendaHistorico_venda1` FOREIGN KEY (`mVendaId`) REFERENCES `venda` (`vendaId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sedaerotica.vendahistorico: ~1 rows (aproximadamente)
DELETE FROM `vendahistorico`;
/*!40000 ALTER TABLE `vendahistorico` DISABLE KEYS */;
INSERT INTO `vendahistorico` (`vendaHistoricoId`, `dtCadastro`, `mVendaId`) VALUES
	(1, '2014-04-21 21:26:40', 2);
/*!40000 ALTER TABLE `vendahistorico` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
