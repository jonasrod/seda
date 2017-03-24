<?php 

include_once "bancodedados.class.php";


class Servicoect
{
	private $bd;
	private $servidoECTID;
	private $codigoServicoECT;
	private $descricaoServicoECT;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->servidoECTID = '';
		$this->codigoServicoECT = '';
		$this->descricaoServicoECT = '';
	}

	public function setServidoECTID( $servidoECTID )
	{
		$this->servidoECTID = $servidoECTID;
	}

	public function setCodigoServicoECT( $codigoServicoECT )
	{
		$this->codigoServicoECT = $codigoServicoECT;
	}

	public function setDescricaoServicoECT( $descricaoServicoECT )
	{
		$this->descricaoServicoECT = $descricaoServicoECT;
	}

	public function getServidoECTID()
	{
		return $this->servidoECTID;
	}

	public function getCodigoServicoECT()
	{
		return $this->codigoServicoECT;
	}

	public function getDescricaoServicoECT()
	{
		return $this->descricaoServicoECT;
	}

	public function obterServicoect( $servicoectID )
	{
		$result = $this->bd->obterRegistroPorId( "servicoect", $servicoectID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarServicoect( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from servicoect ";

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
		$this->setServidoECTID( $row["servidoECTID"] );
		$this->setCodigoServicoECT( $row["codigoServicoECT"] );
		$this->setDescricaoServicoECT( $row["descricaoServicoECT"] );
	}
}
?>