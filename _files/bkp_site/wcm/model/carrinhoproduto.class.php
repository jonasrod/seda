<?php 

include_once "bancodedados.class.php";

include_once 'produto.class.php';

class Carrinhoproduto
{
	private $bd;
	private $mCarrinhoId;
	private $produtoid;
	private $quantidade;
	private $dtCadastro;
	private $valor;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->mCarrinhoId = '';

		$objProdutoId = new Produto();
		$this->produtoid = $objProdutoId;
		$this->quantidade = '';
		$this->dtCadastro = '';
		$this->valor = '';
	}

	public function setMCarrinhoId( $mCarrinhoId )
	{
		$this->mCarrinhoId = $mCarrinhoId;
	}

	public function setProdutoId( $produtoid )
	{
		$this->produtoid = $produtoid;
	}

	public function setQuantidade( $quantidade )
	{
		$this->quantidade = $quantidade;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}
	
	public function setValor( $valor )
	{
		$this->valor = $valor;
	}

	public function getMCarrinhoId()
	{
		return $this->mCarrinhoId;
	}

	public function getProdutoId()
	{
		return $this->produtoid;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}
	
	public function getValor()
	{
		return $this->valor;
	}

	public function obterCarrinhoproduto( $carrinhoprodutoID )
	{
		$result = $this->bd->obterRegistroPorId( "carrinhoproduto", $carrinhoprodutoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarCarrinhoproduto( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from carrinhoproduto ";

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
	
	public function listarComFiltro($result = '')
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
		$this->setMCarrinhoId( $row["mCarrinhoId"] );

		$objProdutoId = new Produto();
		$objProdutoId->obterProduto( $row["mProdutoId"] );

		$this->setProdutoId( $objProdutoId );
		$this->setQuantidade( $row["quantidade"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setValor( $row["valor"] );
	}
}
?>