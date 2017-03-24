<?php 

include_once "bancodedados.class.php";

include_once 'vendaid.class.php';

class Vendahistorico
{
	private $bd;
	private $vendaHistoricoId;
	private $dtCadastro;
	private $vendaid;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->vendaHistoricoId = '';
		$this->dtCadastro = '';

		$objVendaId = new VendaId();
		$this->vendaid = $objVendaId;
	}

	public function setVendaHistoricoId( $vendaHistoricoId )
	{
		$this->vendaHistoricoId = $vendaHistoricoId;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setVendaId( $vendaid )
	{
		$this->vendaid = $vendaid;
	}

	public function getVendaHistoricoId()
	{
		return $this->vendaHistoricoId;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getVendaId()
	{
		return $this->vendaid;
	}

	public function obterVendahistorico( $vendahistoricoID )
	{
		$result = $this->bd->obterRegistroPorId( "vendahistorico", $vendahistoricoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarVendahistorico( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from vendahistorico ";

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
		$this->setVendaHistoricoId( $row["vendaHistoricoId"] );
		$this->setDtCadastro( $row["dtCadastro"] );

		$objVendaId = new VendaId();
		$objVendaId->obterVendaId( $row["mVendaId"] );

		$this->setVendaId( $objVendaId );
	}
}
?>