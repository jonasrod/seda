<?php 

include_once "bancodedados.class.php";


class Referenciasequence
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

	public function obterReferenciasequence( $referenciasequenceID )
	{
		$result = $this->bd->obterRegistroPorId( "referenciasequence", $referenciasequenceID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarReferenciasequence( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from referenciasequence ";

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
		$this->setSequence( $row["sequence"] );
	}
}
?>