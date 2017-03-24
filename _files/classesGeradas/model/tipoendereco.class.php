<?php 

include_once "bancodedados.class.php";


class Tipoendereco
{
	private $bd;
	private $tipoEnderecoId;
	private $descricao;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->tipoEnderecoId = '';
		$this->descricao = '';
		$this->status = '';
	}

	public function setTipoEnderecoId( $tipoEnderecoId )
	{
		$this->tipoEnderecoId = $tipoEnderecoId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getTipoEnderecoId()
	{
		return $this->tipoEnderecoId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterTipoendereco( $tipoenderecoID )
	{
		$result = $this->bd->obterRegistroPorId( "tipoendereco", $tipoenderecoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarTipoendereco( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from tipoendereco ";

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
		$this->setTipoEnderecoId( $row["tipoEnderecoId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setStatus( $row["status"] );
	}
}
?>