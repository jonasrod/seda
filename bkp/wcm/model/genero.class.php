<?php 

include_once "bancodedados.class.php";


class Genero
{
	private $bd;
	private $generoId;
	private $descricao;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->generoId = '';
		$this->descricao = '';
		$this->status = '';
	}

	public function setGeneroId( $generoId )
	{
		$this->generoId = $generoId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getGeneroId()
	{
		return $this->generoId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterGenero( $generoID )
	{
		$result = $this->bd->obterRegistroPorId( "genero", $generoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarGenero( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from genero ";

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
		$this->setGeneroId( $row["generoId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setStatus( $row["status"] );
	}
}
?>