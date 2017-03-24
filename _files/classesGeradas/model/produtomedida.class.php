<?php 

include_once "bancodedados.class.php";

include_once 'produtoid.class.php';

class Produtomedida
{
	private $bd;
	private $medidaId;
	private $produtoid;
	private $medida;
	private $quantidade;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->medidaId = '';

		$objProdutoId = new ProdutoId();
		$this->produtoid = $objProdutoId;
		$this->medida = '';
		$this->quantidade = '';
	}

	public function setMedidaId( $medidaId )
	{
		$this->medidaId = $medidaId;
	}

	public function setProdutoId( $produtoid )
	{
		$this->produtoid = $produtoid;
	}

	public function setMedida( $medida )
	{
		$this->medida = $medida;
	}

	public function setQuantidade( $quantidade )
	{
		$this->quantidade = $quantidade;
	}

	public function getMedidaId()
	{
		return $this->medidaId;
	}

	public function getProdutoId()
	{
		return $this->produtoid;
	}

	public function getMedida()
	{
		return $this->medida;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function obterProdutomedida( $produtomedidaID )
	{
		$result = $this->bd->obterRegistroPorId( "produtomedida", $produtomedidaID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarProdutomedida( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from produtomedida ";

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
		$this->setMedidaId( $row["medidaId"] );

		$objProdutoId = new ProdutoId();
		$objProdutoId->obterProdutoId( $row["mProdutoId"] );

		$this->setProdutoId( $objProdutoId );
		$this->setMedida( $row["medida"] );
		$this->setQuantidade( $row["quantidade"] );
	}
}
?>