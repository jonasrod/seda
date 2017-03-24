<?php 

include_once "bancodedados.class.php";


class TipoCliente
{
	private $bd;
	private $tipoClienteId;
	private $descricao;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->tipoClienteId = '';
		$this->descricao = '';
		$this->status = '';
	}

	public function setTipoClienteId( $tipoClienteId )
	{
		$this->tipoClienteId = $tipoClienteId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getTipoClienteId()
	{
		return $this->tipoClienteId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterTipoCliente( $tipo_clienteID )
	{
		$result = $this->bd->obterRegistroPorId( "tipoCliente", $tipo_clienteID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarTipoCliente( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from tipoCliente ";

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
		$this->setTipoClienteId( $row["tipoClienteId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setStatus( $row["status"] );
	}
}
?>