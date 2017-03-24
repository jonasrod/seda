<?php 

include_once "bancodedados.class.php";

include_once 'carrinhoid.class.php';
include_once 'produtoid.class.php';

class Carrinhoproduto
{
	private $bd;
	private $carrinhoprodutoID;
	private $carrinhoid;
	private $produtoid;
	private $valor;
	private $quantidade;
	private $dtCadastro;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->carrinhoprodutoID = '';

		$objCarrinhoId = new CarrinhoId();
		$this->carrinhoid = $objCarrinhoId;

		$objProdutoId = new ProdutoId();
		$this->produtoid = $objProdutoId;
		$this->valor = '';
		$this->quantidade = '';
		$this->dtCadastro = '';
	}

	public function setCarrinhoprodutoID( $carrinhoprodutoID )
	{
		$this->carrinhoprodutoID = $carrinhoprodutoID;
	}

	public function setCarrinhoId( $carrinhoid )
	{
		$this->carrinhoid = $carrinhoid;
	}

	public function setProdutoId( $produtoid )
	{
		$this->produtoid = $produtoid;
	}

	public function setValor( $valor )
	{
		$this->valor = $valor;
	}

	public function setQuantidade( $quantidade )
	{
		$this->quantidade = $quantidade;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function getCarrinhoprodutoID()
	{
		return $this->carrinhoprodutoID;
	}

	public function getCarrinhoId()
	{
		return $this->carrinhoid;
	}

	public function getProdutoId()
	{
		return $this->produtoid;
	}

	public function getValor()
	{
		return $this->valor;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
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
		$this->setCarrinhoprodutoID( $row["carrinhoprodutoID"] );

		$objCarrinhoId = new CarrinhoId();
		$objCarrinhoId->obterCarrinhoId( $row["mCarrinhoId"] );

		$this->setCarrinhoId( $objCarrinhoId );

		$objProdutoId = new ProdutoId();
		$objProdutoId->obterProdutoId( $row["mProdutoId"] );

		$this->setProdutoId( $objProdutoId );
		$this->setValor( $row["valor"] );
		$this->setQuantidade( $row["quantidade"] );
		$this->setDtCadastro( $row["dtCadastro"] );
	}
}
?>