<?php 

include_once "bancodedados.class.php";


class Fatura
{
	private $bd;
	private $faturaID;
	private $mVendaID;
	private $nossoNumero;
	private $numeroDocumento;
	private $dataVencimento;
	private $dataDocumento;
	private $dataProcessamento;
	private $valorBoleto;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->faturaID = '';
		$this->mVendaID = '';
		$this->nossoNumero = '';
		$this->numeroDocumento = '';
		$this->dataVencimento = '';
		$this->dataDocumento = '';
		$this->dataProcessamento = '';
		$this->valorBoleto = '';
		$this->status = '';
	}

	public function setFaturaID( $faturaID )
	{
		$this->faturaID = $faturaID;
	}

	public function setMVendaID( $mVendaID )
	{
		$this->mVendaID = $mVendaID;
	}

	public function setNossoNumero( $nossoNumero )
	{
		$this->nossoNumero = $nossoNumero;
	}

	public function setNumeroDocumento( $numeroDocumento )
	{
		$this->numeroDocumento = $numeroDocumento;
	}

	public function setDataVencimento( $dataVencimento )
	{
		$this->dataVencimento = $dataVencimento;
	}

	public function setDataDocumento( $dataDocumento )
	{
		$this->dataDocumento = $dataDocumento;
	}

	public function setDataProcessamento( $dataProcessamento )
	{
		$this->dataProcessamento = $dataProcessamento;
	}

	public function setValorBoleto( $valorBoleto )
	{
		$this->valorBoleto = $valorBoleto;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getFaturaID()
	{
		return $this->faturaID;
	}

	public function getMVendaID()
	{
		return $this->mVendaID;
	}

	public function getNossoNumero()
	{
		return $this->nossoNumero;
	}

	public function getNumeroDocumento()
	{
		return $this->numeroDocumento;
	}

	public function getDataVencimento()
	{
		return $this->dataVencimento;
	}

	public function getDataDocumento()
	{
		return $this->dataDocumento;
	}

	public function getDataProcessamento()
	{
		return $this->dataProcessamento;
	}

	public function getValorBoleto()
	{
		return $this->valorBoleto;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterFatura( $faturaID )
	{
		$result = $this->bd->obterRegistroPorId( "fatura", $faturaID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterFaturaPorVendaId( $vendaID )
	{
		$sql  = "select * ";
		$sql .= "from fatura ";
		$sql .= "where mVendaID = $vendaID";
		
		$result = $this->bd->executarSQL($sql);
		
		if ( $result->num_rows > 0 )
			return $this->montarObjeto( $result->fetch_array() );
		else
			return null;
	}

	public function listarFatura( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from fatura ";

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
		$this->setFaturaID( $row["faturaID"] );
		$this->setMVendaID( $row["mVendaID"] );
		$this->setNossoNumero( $row["nossoNumero"] );
		$this->setNumeroDocumento( $row["numeroDocumento"] );
		$this->setDataVencimento( $row["dataVencimento"] );
		$this->setDataDocumento( $row["dataDocumento"] );
		$this->setDataProcessamento( $row["dataProcessamento"] );
		$this->setValorBoleto( $row["valorBoleto"] );
		$this->setStatus( $row["status"] );
	}
}
?>