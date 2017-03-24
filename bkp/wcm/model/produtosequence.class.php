<?php 

include_once "bancodedados.class.php";


class Produtosequence
{
	private $bd;
	private $sequence;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->sequence = '';
	}

	public function setSequence( $sequence )
	{
		$this->sequence = $sequence;
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	public function obterProdutosequence( $produtosequenceID )
	{
		$result = $this->bd->obterRegistroPorId( "produtosequence", $produtosequenceID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarProdutosequence( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from produtosequence ";

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
	
	public function getLastID() 
	{
		$sql  = "select * ";
		$sql .= "from produtosequence ";
	
		$result = $this->bd->executarSQL($sql);
		$this->montarObjeto($result->fetch_array());
		
		$this->bd = BancodeDados::getInstance();
		$this->bd->edit("produtosequence", array("sequence" => $this->getSequence() + 1));
		$this->bd->commit();
		
		return $this->getSequence();
	}

	private function montarObjeto( $row )
	{
		$this->setSequence( $row["sequence"] );
	}
}
?>