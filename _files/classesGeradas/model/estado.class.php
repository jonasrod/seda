<?php 

include_once "bancodedados.class.php";


class Estado
{
	private $bd;
	private $estadoID;
	private $sigla;
	private $descricao;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->estadoID = '';
		$this->sigla = '';
		$this->descricao = '';
	}

	public function setEstadoID( $estadoID )
	{
		$this->estadoID = $estadoID;
	}

	public function setSigla( $sigla )
	{
		$this->sigla = $sigla;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function getEstadoID()
	{
		return $this->estadoID;
	}

	public function getSigla()
	{
		return $this->sigla;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function obterEstado( $estadoID )
	{
		$result = $this->bd->obterRegistroPorId( "estado", $estadoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarEstado( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from estado ";

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
		$this->setEstadoID( $row["estadoID"] );
		$this->setSigla( $row["sigla"] );
		$this->setDescricao( $row["descricao"] );
	}
}
?>