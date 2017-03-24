<?php 

include_once "bancodedados.class.php";

include_once 'categoriaid.class.php';

class Subcategoria
{
	private $bd;
	private $subcategoriaId;
	private $descricao;
	private $dtCadastro;
	private $categoriaid;
	private $status;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->subcategoriaId = '';
		$this->descricao = '';
		$this->dtCadastro = '';

		$objCategoriaId = new CategoriaId();
		$this->categoriaid = $objCategoriaId;
		$this->status = '';
	}

	public function setSubcategoriaId( $subcategoriaId )
	{
		$this->subcategoriaId = $subcategoriaId;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setCategoriaId( $categoriaid )
	{
		$this->categoriaid = $categoriaid;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function getSubcategoriaId()
	{
		return $this->subcategoriaId;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getCategoriaId()
	{
		return $this->categoriaid;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function obterSubcategoria( $subcategoriaID )
	{
		$result = $this->bd->obterRegistroPorId( "subcategoria", $subcategoriaID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarSubcategoria( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from subcategoria ";

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
		$this->setSubcategoriaId( $row["subcategoriaId"] );
		$this->setDescricao( $row["descricao"] );
		$this->setDtCadastro( $row["dtCadastro"] );

		$objCategoriaId = new CategoriaId();
		$objCategoriaId->obterCategoriaId( $row["mCategoriaId"] );

		$this->setCategoriaId( $objCategoriaId );
		$this->setStatus( $row["status"] );
	}
}
?>