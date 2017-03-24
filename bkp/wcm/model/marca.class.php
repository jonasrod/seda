<?php 

include_once "bancodedados.class.php";


class Marca
{
	private $bd;
	private $marcaId;
	private $descricao;
	private $dtCadastro;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->marcaId = '';
		$this->descricao = '';
		$this->dtCadastro = '';
		$this->status = '';
	}

	public function setMarcaId( $marcaId )
	{
		$this->marcaId = $marcaId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getMarcaId()
	{
		return $this->marcaId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterMarca( $marcaID )
	{
		$result = $this->bd->obterRegistroPorId( "marca", $marcaID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterMarcaPorNome( $marcaNome )
	{
		$sql = "select * from marca where LOWER(descricao) like '%$marcaNome%'";
		$result = $this->bd->executarSQL($sql);
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarMarca( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from marca ";

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
	
	public function listarMarcaComFiltro($result = '')
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

	private function montarObjeto( $row )
	{
		$this->setMarcaId( $row["marcaId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setStatus( $row["status"] );
	}
}
?>