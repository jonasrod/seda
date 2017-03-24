<?php 

include_once "bancodedados.class.php";


class Tipopagamento
{
	private $bd;
	private $tipoPagamentoId;
	private $descricao;
	private $status;
	private $dtCadastro;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->tipoPagamentoId = '';
		$this->descricao = '';
		$this->status = '';
		$this->dtCadastro = '';
	}

	public function setTipoPagamentoId( $tipoPagamentoId )
	{
		$this->tipoPagamentoId = $tipoPagamentoId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function getTipoPagamentoId()
	{
		return $this->tipoPagamentoId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function obterTipopagamento( $tipopagamentoID )
	{
		$result = $this->bd->obterRegistroPorId( "tipopagamento", $tipopagamentoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarTipopagamento( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from tipopagamento ";

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
		$this->setTipoPagamentoId( $row["tipoPagamentoId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setStatus( $row["status"] );
		$this->setDtCadastro( $row["dtCadastro"] );
	}
}
?>