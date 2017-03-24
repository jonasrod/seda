<?php 

include_once "bancodedados.class.php";

include_once 'categoriaid.class.php';
include_once 'subcategoriaid.class.php';
include_once 'produtoid.class.php';

class Produtocategoria
{
	private $bd;
	private $produtocategoriaID;
	private $categoriaid;
	private $subcategoriaid;
	private $produtoid;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->produtocategoriaID = '';

		$objCategoriaId = new CategoriaId();
		$this->categoriaid = $objCategoriaId;

		$objSubcategoriaId = new SubcategoriaId();
		$this->subcategoriaid = $objSubcategoriaId;

		$objProdutoId = new ProdutoId();
		$this->produtoid = $objProdutoId;
	}

	public function setProdutocategoriaID( $produtocategoriaID )
	{
		$this->produtocategoriaID = $produtocategoriaID;
	}

	public function setCategoriaId( $categoriaid )
	{
		$this->categoriaid = $categoriaid;
	}

	public function setSubcategoriaId( $subcategoriaid )
	{
		$this->subcategoriaid = $subcategoriaid;
	}

	public function setProdutoId( $produtoid )
	{
		$this->produtoid = $produtoid;
	}

	public function getProdutocategoriaID()
	{
		return $this->produtocategoriaID;
	}

	public function getCategoriaId()
	{
		return $this->categoriaid;
	}

	public function getSubcategoriaId()
	{
		return $this->subcategoriaid;
	}

	public function getProdutoId()
	{
		return $this->produtoid;
	}

	public function obterProdutocategoria( $produtocategoriaID )
	{
		$result = $this->bd->obterRegistroPorId( "produtocategoria", $produtocategoriaID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarProdutocategoria( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from produtocategoria ";

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
		$this->setProdutocategoriaID( $row["produtocategoriaID"] );

		$objCategoriaId = new CategoriaId();
		$objCategoriaId->obterCategoriaId( $row["mCategoriaId"] );

		$this->setCategoriaId( $objCategoriaId );

		$objSubcategoriaId = new SubcategoriaId();
		$objSubcategoriaId->obterSubcategoriaId( $row["mSubcategoriaId"] );

		$this->setSubcategoriaId( $objSubcategoriaId );

		$objProdutoId = new ProdutoId();
		$objProdutoId->obterProdutoId( $row["mProdutoId"] );

		$this->setProdutoId( $objProdutoId );
	}
}
?>