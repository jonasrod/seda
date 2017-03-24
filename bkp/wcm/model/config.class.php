<?php 

include_once "bancodedados.class.php";


class Config
{
	private $bd;
	private $configID;
	private $chave;
	private $valor;
	private $descricao;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->configID = '';
		$this->chave = '';
		$this->valor = '';
		$this->descricao = '';
	}

	public function setConfigID( $configID )
	{
		$this->configID = $configID;
	}

	public function setChave( $chave )
	{
		$this->chave = $chave;
	}

	public function setValor( $valor )
	{
		$this->valor = $valor;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function getConfigID()
	{
		return $this->configID;
	}

	public function getChave()
	{
		return $this->chave;
	}

	public function getValor()
	{
		return $this->valor;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function obterConfig( $configID )
	{
		$result = $this->bd->obterRegistroPorId( "config", $configID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterConfigPorChave( $chave )
	{
		$sql = "select * from config where chave = '$chave'";
		$result = $this->bd->executarSQL($sql);
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarConfig( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from config ";

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
		$this->setConfigID( $row["configID"] );
		$this->setChave( $row["chave"] );
		$this->setValor( $row["valor"] );
		$this->setDescricao( $row["descricao"] );
	}
}
?>