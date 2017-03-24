<?php 

include_once "bancodedados.class.php";

class Produtomedida
{
	private $bd;
	private $medidaId;
	private $medida;
	private $quantidade;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->medidaId = '';
		$this->medida = '';
		$this->quantidade = '';
	}

	public function setMedidaId( $medidaId )
	{
		$this->medidaId = $medidaId;
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
	
	public function listarProdutomedida( $mProdutoId )
	{
		$sql  = "select * ";
		$sql .= "from produtomedida ";
		$sql .= "where mProdutoId = " . $mProdutoId;
	
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
		$this->setMedida( $row["medida"] );
		$this->setQuantidade( $row["quantidade"] );
	}
}
?>