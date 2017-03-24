<?php 

include_once "bancodedados.class.php";

include_once 'carrinho.class.php';
include_once 'tipopagamento.class.php';

class Venda
{
	private $bd;
	private $vendaId;
	private $carrinhoid;
	private $mClienteId;
	private $tipopagamentoid;
	private $referencia;
	private $status;
	private $valorTotalProduto;
	private $valorFrete;
	private $valorDesconto;
	private $dtCadastro;
	private $pagseguroId;
	private $cieloId;
	private $rastreamento;
	private $tipoEntrega;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->vendaId = '';

		$objCarrinhoId = new Carrinho();
		$this->carrinhoid = $objCarrinhoId;
		$this->mClienteId = '';

		$objTipoPagamentoId = new TipoPagamento();
		$this->tipopagamentoid = $objTipoPagamentoId;
		$this->referencia = '';
		$this->status = '';
		$this->valorTotalProduto = '';
		$this->valorFrete = '';
		$this->valorDesconto = '';
		$this->dtCadastro = '';
		$this->pagseguroId = '';
		$this->cieloId = '';
		$this->rastreamento = '';
		$this->tipoEntrega = '';
	}

	public function setVendaId( $vendaId )
	{
		$this->vendaId = $vendaId;
	}

	public function setCarrinhoId( $carrinhoid )
	{
		$this->carrinhoid = $carrinhoid;
	}

	public function setMClienteId( $mClienteId )
	{
		$this->mClienteId = $mClienteId;
	}

	public function setTipoPagamentoId( $tipopagamentoid )
	{
		$this->tipopagamentoid = $tipopagamentoid;
	}

	public function setReferencia( $referencia )
	{
		$this->referencia = $referencia;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setValorTotalProduto( $valorTotalProduto )
	{
		$this->valorTotalProduto = $valorTotalProduto;
	}

	public function setValorFrete( $valorFrete )
	{
		$this->valorFrete = $valorFrete;
	}

	public function setValorDesconto( $valorDesconto )
	{
		$this->valorDesconto = $valorDesconto;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}
	
	public function setPagseguroId($pagseguroId)
	{
		$this->pagseguroId = $pagseguroId;
	}
	
	public function setCieloId($cieloId)
	{
		$this->cieloId = $cieloId;
	}
	
	public function setRastreamento($rastreamento)
	{
		$this->rastreamento = $rastreamento;
	}
	
	public function setTipoEntrega($tipoEntrega)
	{
		$this->tipoEntrega = $tipoEntrega;
	}

	public function getVendaId()
	{
		return $this->vendaId;
	}

	public function getCarrinhoId()
	{
		return $this->carrinhoid;
	}

	public function getMClienteId()
	{
		return $this->mClienteId;
	}

	public function getTipoPagamentoId()
	{
		return $this->tipopagamentoid;
	}

	public function getReferencia()
	{
		return $this->referencia;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getValorTotalProduto()
	{
		return $this->valorTotalProduto;
	}

	public function getValorFrete()
	{
		return $this->valorFrete;
	}

	public function getValorDesconto()
	{
		return $this->valorDesconto;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}
	
	public function getPagseguroId()
	{
		return $this->pagseguroId;
	}
	
	public function getCieloId()
	{
		return $this->cieloId;
	}
	
	public function getRastreamento()
	{
		return $this->rastreamento;
	}
	
	public function getTipoEntrega()
	{
		return $this->tipoEntrega;
	}

	public function obterVenda( $vendaID )
	{
		$result = $this->bd->obterRegistroPorId( "venda", $vendaID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterVendaPorNumPedido( $numPedido )
	{
		$sql  = "select * ";
		$sql .= "from venda ";
		$sql .= "where referencia = '$numPedido'";
		
		$result = $this->bd->executarSQL($sql);
		
		if ( $result->num_rows > 0 )
			return $this->montarObjeto( $result->fetch_array() );
		else
			return null;
	}

	public function listarVenda( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from venda ";

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
	
	public function listarComFiltro($result = '')
    {
        if ($result->num_rows > 0)
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
	
	public function obterVendaPagseguroId( $pagseguroID )
	{
		$sql  = "select * ";
		$sql .= "from venda ";
		$sql .= "where pagseguroId = '$pagseguroID'";

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarObjeto( $result->fetch_array() );
		else
			return null;
	}

	private function montarObjeto( $row )
	{
		$this->setVendaId( $row["vendaId"] );

		$objCarrinhoId = new Carrinho();
		$objCarrinhoId->obterCarrinho( $row["mCarrinhoId"] );

		$this->setCarrinhoId( $objCarrinhoId );
		$this->setMClienteId( $row["mClienteId"] );

		$objTipoPagamentoId = new TipoPagamento();
		$objTipoPagamentoId->obterTipoPagamento( $row["mTipoPagamentoId"] );

		$this->setTipoPagamentoId( $objTipoPagamentoId );
		$this->setReferencia( $row["referencia"] );
		$this->setStatus( $row["status"] );
		$this->setValorTotalProduto( $row["valorTotalProduto"] );
		$this->setValorFrete( $row["valorFrete"] );
		$this->setValorDesconto( $row["valorDesconto"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setPagseguroId( $row["pagseguroId"] );
		$this->setCieloId( $row["cieloId"] );
		$this->setRastreamento( $row["rastreamento"] );
		$this->setTipoEntrega( $row["tipoEntrega"] );
	}
}
?>