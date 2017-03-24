<?php 

include_once "bancodedados.class.php";

include_once 'cliente.class.php';
include_once 'tipo_endereco.class.php';

class Endereco
{
	private $bd;
	private $enderecoId;
	private $clienteid;
	private $tipoenderecoid;
	private $cep;
	private $endereco;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $estado;
	private $observacoes;

	public function __construct()
	{
		$this->bd = new BancodeDados();

		$this->enderecoId = '';

		$objClienteId = new Cliente();
		$this->clienteid = $objClienteId;

		$objTipoEnderecoId = new TipoEndereco();
		$this->tipoenderecoid = $objTipoEnderecoId;
		$this->cep = '';
		$this->endereco = '';
		$this->numero = '';
		$this->complemento = '';
		$this->bairro = '';
		$this->cidade = '';
		$this->estado = '';
		$this->observacoes = '';
	}

	public function setEnderecoId( $enderecoId )
	{
		$this->enderecoId = $enderecoId;
	}

	public function setClienteId( $clienteid )
	{
		$this->clienteid = $clienteid;
	}

	public function setTipoEnderecoId( $tipoenderecoid )
	{
		$this->tipoenderecoid = $tipoenderecoid;
	}

	public function setCep( $cep )
	{
		$this->cep = $cep;
	}

	public function setEndereco( $endereco )
	{
		$this->endereco = $endereco;
	}

	public function setNumero( $numero )
	{
		$this->numero = $numero;
	}

	public function setComplemento( $complemento )
	{
		$this->complemento = $complemento;
	}

	public function setBairro( $bairro )
	{
		$this->bairro = $bairro;
	}

	public function setCidade( $cidade )
	{
		$this->cidade = $cidade;
	}

	public function setEstado( $estado )
	{
		$this->estado = $estado;
	}

	public function setObservacoes( $observacoes )
	{
		$this->observacoes = $observacoes;
	}

	public function getEnderecoId()
	{
		return $this->enderecoId;
	}

	public function getClienteId()
	{
		return $this->clienteid;
	}

	public function getTipoEnderecoId()
	{
		return $this->tipoenderecoid;
	}

	public function getCep()
	{
		return $this->cep;
	}

	public function getEndereco()
	{
		return $this->endereco;
	}

	public function getNumero()
	{
		return $this->numero;
	}

	public function getComplemento()
	{
		return $this->complemento;
	}

	public function getBairro()
	{
		return $this->bairro;
	}

	public function getCidade()
	{
		return $this->cidade;
	}

	public function getEstado()
	{
		return $this->estado;
	}

	public function getObservacoes()
	{
		return $this->observacoes;
	}

	public function obterEndereco( $enderecoID )
	{
		$result = $this->bd->obterRegistroPorId( "endereco", $enderecoID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterEnderecoPorCliente( $clienteID )
	{
		$sql = "select * from endereco where mClienteId = $clienteID and mTipoEnderecoId = 2"; // seleciona o endereco de entrega
		$result = $this->bd->executarSQL( $sql );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarEndereco( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from endereco ";

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
		$this->setEnderecoId( $row["enderecoId"] );

		//$objClienteId = new Cliente();
		//$objClienteId->obterCliente( $row["mClienteId"] );

		//$this->setClienteId( $objClienteId );

		$objTipoEnderecoId = new TipoEndereco();
		$objTipoEnderecoId->obterTipoEndereco( $row["mTipoEnderecoId"] );

		$this->setTipoEnderecoId( $objTipoEnderecoId );
		$this->setCep( $row["cep"] );
		$this->setEndereco( $row["endereco"] );
		$this->setNumero( $row["numero"] );
		$this->setComplemento( $row["complemento"] );
		$this->setBairro( $row["bairro"] );
		$this->setCidade( $row["cidade"] );
		$this->setEstado( $row["estado"] );
		$this->setObservacoes( $row["observacoes"] );
	}
}
?>