<?php 

include_once "bancodedados.class.php";

include_once 'clienteid.class.php';
include_once 'tipoenderecoid.class.php';
include_once 'estadoid.class.php';

class Endereco
{
	private $bd;
	private $enderecoId;
	private $clienteid;
	private $tipoenderecoid;
	private $estadoid;
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
		$this->bd = BancodeDados::getInstance();

		$this->enderecoId = '';

		$objClienteId = new ClienteId();
		$this->clienteid = $objClienteId;

		$objTipoEnderecoId = new TipoEnderecoId();
		$this->tipoenderecoid = $objTipoEnderecoId;

		$objEstadoID = new EstadoID();
		$this->estadoid = $objEstadoID;
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

	public function setEstadoID( $estadoid )
	{
		$this->estadoid = $estadoid;
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

	public function getEstadoID()
	{
		return $this->estadoid;
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

		$objClienteId = new ClienteId();
		$objClienteId->obterClienteId( $row["mClienteId"] );

		$this->setClienteId( $objClienteId );

		$objTipoEnderecoId = new TipoEnderecoId();
		$objTipoEnderecoId->obterTipoEnderecoId( $row["mTipoEnderecoId"] );

		$this->setTipoEnderecoId( $objTipoEnderecoId );

		$objEstadoID = new EstadoID();
		$objEstadoID->obterEstadoID( $row["mEstadoID"] );

		$this->setEstadoID( $objEstadoID );
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