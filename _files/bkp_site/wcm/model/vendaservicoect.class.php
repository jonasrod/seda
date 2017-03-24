<?php 

include_once "bancodedados.class.php";

include_once 'venda.class.php';
include_once 'servicoect.class.php';

class Vendaservicoect
{
	private $bd;
	private $vendaServicoECTID;
	private $vendaid;
	private $servicoetcid;
	private $codigoObjetoECT;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->vendaServicoECTID = '';

		$objVendaId = new Venda();
		$this->vendaid = $objVendaId;

		$objServicoETCID = new ServicoETC();
		$this->servicoetcid = $objServicoETCID;
		$this->codigoObjetoECT = '';
	}

	public function setVendaServicoECTID( $vendaServicoECTID )
	{
		$this->vendaServicoECTID = $vendaServicoECTID;
	}

	public function setVendaId( $vendaid )
	{
		$this->vendaid = $vendaid;
	}

	public function setServicoETCID( $servicoetcid )
	{
		$this->servicoetcid = $servicoetcid;
	}

	public function setCodigoObjetoECT( $codigoObjetoECT )
	{
		$this->codigoObjetoECT = $codigoObjetoECT;
	}

	public function getVendaServicoECTID()
	{
		return $this->vendaServicoECTID;
	}

	public function getVendaId()
	{
		return $this->vendaid;
	}

	public function getServicoETCID()
	{
		return $this->servicoetcid;
	}

	public function getCodigoObjetoECT()
	{
		return $this->codigoObjetoECT;
	}

	public function obterVendaservicoect( $vendaservicoectID )
	{
		$result = $this->bd->obterRegistroPorId( "vendaservicoect", $vendaservicoectID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarVendaservicoect( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from vendaservicoect ";

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
		$this->setVendaServicoECTID( $row["vendaServicoECTID"] );

		$objVendaId = new Venda();
		$objVendaId->obterVenda( $row["mVendaId"] );

		$this->setVendaId( $objVendaId );

		$objServicoETCID = new ServicoETC();
		$objServicoETCID->obterServicoETC( $row["mServicoETCID"] );

		$this->setServicoETCID( $objServicoETCID );
		$this->setCodigoObjetoECT( $row["codigoObjetoECT"] );
	}
}
?>