<?php 

include_once "bancodedados.class.php";

include_once 'clienteid.class.php';

class Carrinho
{
	private $bd;
	private $carrinhoId;
	private $clienteid;
	private $presente;
	private $mensagemPresente;
	private $chaveSeguranca;
	private $dtCadastro;
	private $dtAtualizacao;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->carrinhoId = '';

		$objClienteId = new ClienteId();
		$this->clienteid = $objClienteId;
		$this->presente = '';
		$this->mensagemPresente = '';
		$this->chaveSeguranca = '';
		$this->dtCadastro = '';
		$this->dtAtualizacao = '';
	}

	public function setCarrinhoId( $carrinhoId )
	{
		$this->carrinhoId = $carrinhoId;
	}

	public function setClienteId( $clienteid )
	{
		$this->clienteid = $clienteid;
	}

	public function setPresente( $presente )
	{
		$this->presente = $presente;
	}

	public function setMensagemPresente( $mensagemPresente )
	{
		$this->mensagemPresente = $mensagemPresente;
	}

	public function setChaveSeguranca( $chaveSeguranca )
	{
		$this->chaveSeguranca = $chaveSeguranca;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setDtAtualizacao( $dtAtualizacao )
	{
		$this->dtAtualizacao = $dtAtualizacao;
	}

	public function getCarrinhoId()
	{
		return $this->carrinhoId;
	}

	public function getClienteId()
	{
		return $this->clienteid;
	}

	public function getPresente()
	{
		return $this->presente;
	}

	public function getMensagemPresente()
	{
		return $this->mensagemPresente;
	}

	public function getChaveSeguranca()
	{
		return $this->chaveSeguranca;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getDtAtualizacao()
	{
		return $this->dtAtualizacao;
	}

	public function obterCarrinho( $carrinhoID )
	{
		$result = $this->bd->obterRegistroPorId( "carrinho", $carrinhoID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarCarrinho( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from carrinho ";

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
		$this->setCarrinhoId( $row["carrinhoId"] );

		$objClienteId = new ClienteId();
		$objClienteId->obterClienteId( $row["mClienteId"] );

		$this->setClienteId( $objClienteId );
		$this->setPresente( $row["presente"] );
		$this->setMensagemPresente( $row["mensagemPresente"] );
		$this->setChaveSeguranca( $row["chaveSeguranca"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setDtAtualizacao( $row["dtAtualizacao"] );
	}
}
?>