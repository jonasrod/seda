<?php 

include_once "bancodedados.class.php";

include_once 'marca.class.php';
include_once 'produtocategoria.class.php';

class Produto
{
	private $bd;
	private $produtoId;
	private $marcaid;
	private $subcategoriaid;
	private $codigoProduto;
	private $titulo;
	private $descricao;
	private $dtCadastro;
	private $dtAutualizacao;
	private $status;
	private $valor;
	private $valorOriginal;
	private $quantidade;
	private $quantidadeMinima;
	private $peso;
	private $destaque;
	private $informacao;
	private $desconto;
	private $flPromocao;
	private $flLancamento;
	private $altura;
	private $largura;
	private $comprimento;
	private $tamanho;
	private $listaCategorias;
	private $infotecnica;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->produtoId = '';

		$objMarcaId = new Marca();
		$this->marcaid = $objMarcaId;

		$objSubcategoriaId = new Subcategoria();
		$this->subcategoriaid = $objSubcategoriaId;
		$this->codigoProduto = '';
		$this->titulo = '';
		$this->descricao = '';
		$this->dtCadastro = '';
		$this->dtAutualizacao = '';
		$this->status = '';
		$this->valor = '';
		$this->valorOriginal = '';
		$this->quantidade = '';
		$this->quantidadeMinima = '';
		$this->peso = '';
		$this->destaque = '';
		$this->informacao = '';
		$this->desconto = '';
		$this->flPromocao = '';
		$this->flLancamento = '';
		$this->altura = '';
		$this->largura = '';
		$this->comprimento = '';
		$this->tamanho = '';
		$this->infotecnica = '';
		$this->listaCategorias = array();
	}

	public function setProdutoId( $produtoId )
	{
		$this->produtoId = $produtoId;
	}

	public function setMarcaId( $marcaid )
	{
		$this->marcaid = $marcaid;
	}

	public function setSubcategoriaId( $subcategoriaid )
	{
		$this->subcategoriaid = $subcategoriaid;
	}

	public function setCodigoProduto( $codigoProduto )
	{
		$this->codigoProduto = $codigoProduto;
	}

	public function setTitulo( $titulo )
	{
		$this->titulo = $titulo;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setDtAutualizacao( $dtAutualizacao )
	{
		$this->dtAutualizacao = $dtAutualizacao;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setValor( $valor )
	{
		$this->valor = $valor;
	}
	
	public function setValorOriginal( $valorOriginal )
	{
		$this->valorOriginal = $valorOriginal;
	}

	public function setQuantidade( $quantidade )
	{
		$this->quantidade = $quantidade;
	}

	public function setQuantidadeMinima( $quantidadeMinima )
	{
		$this->quantidadeMinima = $quantidadeMinima;
	}

	public function setPeso( $peso )
	{
		$this->peso = $peso;
	}

	public function setDestaque( $destaque )
	{
		$this->destaque = $destaque;
	}

	public function setInformacao( $informacao )
	{
		$this->informacao = $informacao;
	}

	public function setDesconto( $desconto )
	{
		$this->desconto = $desconto;
	}
	
	public function setFlPromocao( $flPromocao )
	{
		$this->flPromocao = $flPromocao;
	}
	
	public function setFlLancamento( $flLancamento )
	{
		$this->flLancamento = $flLancamento;
	}
	
	public function setAltura( $altura )
	{
		$this->altura = $altura;
	}

	public function setLargura( $largura )
	{
		$this->largura = $largura;
	}

	public function setComprimento( $comprimento )
	{
		$this->comprimento = $comprimento;
	}
	
	public function setListaCategorias( $listaCategorias )
	{
		$this->listaCategorias = $listaCategorias;
	}
	
	public function setTamanho( $tamanho )
	{
		$this->tamanho = $tamanho;
	}
	
	public function setInfotecnica( $infotecnica )
	{
		$this->infotecnica = $infotecnica;
	}

	public function getProdutoId()
	{
		return $this->produtoId;
	}

	public function getMarcaId()
	{
		return $this->marcaid;
	}

	public function getSubcategoriaId()
	{
		return $this->subcategoriaid;
	}

	public function getCodigoProduto()
	{
		return $this->codigoProduto;
	}

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getDtAutualizacao()
	{
		return $this->dtAutualizacao;
	}

	public function getStatus()
	{
		return $this->status;
	}
	
	/**
	 * Retorna o valor já com desconto
	 */
	public function getValor()
	{
		if ($this->desconto != '' && $this->desconto != 0) {
			return $this->valor - ($this->valor * ($this->desconto / 100));
		} else {
			return $this->valor;
		}
	}
	
	/**
	 * Retorna o valor sem desconto
	 */
	public function getValorOriginal()
	{
		return $this->valor;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function getQuantidadeMinima()
	{
		return $this->quantidadeMinima;
	}

	public function getPeso()
	{
		return $this->peso;
	}

	public function getDestaque()
	{
		return $this->destaque;
	}

	public function getInformacao()
	{
		return $this->informacao;
	}

	public function getDesconto()
	{
		return $this->desconto;
	}
	
	public function getFlPromocao()
	{
		return $this->flPromocao;
	}
	
	public function getFlLancamento()
	{
		return  $this->flLancamento;
	}
	
	public function getAltura()
	{
		return $this->altura;
	}

	public function getLargura()
	{
		return $this->largura;
	}

	public function getComprimento()
	{
		return $this->comprimento;
	}
	
	public function getListaCategorias()
	{
		return $this->listaCategorias;
	}
	
	public function getTamanho()
	{
		return $this->tamanho;
	}
	
	public function getInfotecnica()
	{
		return $this->infotecnica;
	}

	public function obterProduto( $produtoID )
	{
		$result = $this->bd->obterRegistroPorId( "produto", $produtoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarProduto( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from produto ";

		if ($objPaginacao)
		{
			$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
		}

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarLista($result);
		else
			return array();
	}
	
	public function listarProdutoLancamento( Paginacao $objPaginacao = NULL, $orderBy = null )
	{
		$sql  = "select p.* from produto as p, marca as m " .
				"where " .
				"		p.flLancamento = 1 " .
				"and " .
				"		m.marcaId = p.mMarcaId " .
				"and " .
				"		p.status = 1 " .
				"and " .
				"		p.quantidade > 0 ";
		if (isset($orderBy)) {
			$sql .= " order by $orderBy ";
		}
				
		if ($objPaginacao)
		{
			$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
		}

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarLista($result);
		else
			return array();
	}
	
	public function listarProdutoPromocao( Paginacao $objPaginacao = NULL, $orderBy = null )
	{
		$sql  = "select p.* from produto as p, marca as m " .
				"where " .
				"		p.flPromocao = 1 " .
				"and " .
				"		m.marcaId = p.mMarcaId " .
				"and " .
				"		p.status = 1 " .
				"and " .
				"		p.quantidade > 0 ";
		if (isset($orderBy)) {
			$sql .= " order by $orderBy ";
		}
				
		if ($objPaginacao)
		{
			$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
		}

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarLista($result);
		else
			return array();
	}
	
	public function listarCategoriaComFiltro($result = '')
    {
        if ($result->num_rows > 0)
            return $this->montarLista($result);
        else
            return array();
    }
	
	public function listarProdutoComFiltro($result = '')
    {
        if ($result->num_rows > 0)
            return $this->montarLista($result);
        else
            return array();
    }

	private function montarLista( $result )
	{
		if( $result->num_rows > 0 )
		{
			while( $row = $result->fetch_array() )
			{
				$obj = new self();
				$obj->montarObjeto( $row );
				$objs[] = $obj;
				$obj = null;
			}
			return $objs;
		}
		else
		{
			return false;
		}
	}

	private function montarObjeto( $row )
	{
		$this->setProdutoId( $row["produtoId"] );

		$objMarcaId = new Marca();
		$objMarcaId->obterMarca( $row["mMarcaId"] );

		$this->setMarcaId( $objMarcaId );

		$objProdutoCategoria = new Produtocategoria();
		
		$this->setListaCategorias($objProdutoCategoria->listarProdutocategoria( $row["produtoId"] ));
		//$this->setSubcategoriaId( $objSubcategoriaId );
		$this->setCodigoProduto( $row["codigoProduto"] );
		$this->setTitulo( $row["titulo"] );
		$this->setDescricao( $row["descricao"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setDtAutualizacao( $row["dtAutualizacao"] );
		$this->setStatus( $row["status"] );
		$this->setValor( $row["valor"] );
		$this->setValorOriginal( $row["valorOriginal"] );
		$this->setQuantidade( $row["quantidade"] );
		$this->setQuantidadeMinima( $row["quantidadeMinima"] );
		$this->setPeso( $row["peso"] );
		$this->setDestaque( $row["destaque"] );
		$this->setInformacao( $row["informacao"] );
		$this->setDesconto( $row["desconto"] );
		$this->setFlPromocao( $row["flPromocao"] );
		$this->setFlLancamento( $row["flLancamento"] );
		$this->setAltura( $row["altura"] );
		$this->setLargura( $row["largura"] );
		$this->setComprimento( $row["comprimento"] );
		$this->setTamanho( $row["tamanho"] );
		$this->setInfotecnica( $row["infotecnica"] );
	}
}
?>