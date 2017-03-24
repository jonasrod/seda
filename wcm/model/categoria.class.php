<?php 

include_once "bancodedados.class.php";


class Categoria
{
	private $bd;
	private $categoriaId;
	private $descricao;
	private $dtCadastro;
	private $status;
	
	public function __construct(BancodeDados $bdParam = null)
	{
		if ($bdParam == null) {
			$this->bd = BancodeDados::getInstance();
		} else {
			$this->bd = $bdParam;
		}

		$this->categoriaId = '';
		$this->descricao = '';
		$this->dtCadastro = '';
		$this->status = '';
	}

	public function setCategoriaId( $categoriaId )
	{
		$this->categoriaId = $categoriaId;
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

	public function getCategoriaId()
	{
		return $this->categoriaId;
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

	public function obterCategoria( $categoriaID )
	{
		$result = $this->bd->obterRegistroPorId( "categoria", $categoriaID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterCategoriaPorNome( $categoria )
	{
		$sql = "select * from categoria where LOWER(descricao) like '$categoria'";
		$result = $this->bd->executarSQL($sql);
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarCategoria( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from categoria ";

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
	
	public function listarCategoriaComFiltro($result = '')
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
		$this->setCategoriaId( $row["categoriaId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setStatus( $row["status"] );
	}
}
?>