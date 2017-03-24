<?php 

include_once "bancodedados.class.php";


class Embalagem
{
	private $bd;
	private $embalagemId;
	private $descricao;
	private $altura;
	private $largura;
	private $comprimento;
	private $status;
	private $dtCadastro;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->embalagemId = '';
		$this->descricao = '';
		$this->altura = '';
		$this->largura = '';
		$this->comprimento = '';
		$this->status = '';
		$this->dtCadastro = '';
	}

	public function setEmbalagemId( $embalagemId )
	{
		$this->embalagemId = $embalagemId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setAltura( $altura )
	{
		$this->altura = $altura;
	}

	public function setLargura( $largura )
	{
		$this->largura = $largura;
	}

	public function setComprimento( $comprimento )
	{
		$this->comprimento = $comprimento;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function getEmbalagemId()
	{
		return $this->embalagemId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getAltura()
	{
		return $this->altura;
	}

	public function getLargura()
	{
		return $this->largura;
	}

	public function getComprimento()
	{
		return $this->comprimento;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function obterEmbalagem( $embalagemID )
	{
		$result = $this->bd->obterRegistroPorId( "embalagem", $embalagemID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarEmbalagem( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from embalagem ";

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
		$this->setEmbalagemId( $row["embalagemId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setAltura( $row["altura"] );
		$this->setLargura( $row["largura"] );
		$this->setComprimento( $row["comprimento"] );
		$this->setStatus( $row["status"] );
		$this->setDtCadastro( $row["dtCadastro"] );
	}
}
?>