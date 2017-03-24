<?php 

include_once "bancodedados.class.php";

include_once 'categoria.class.php';
include_once 'subcategoria.class.php';
include_once 'produto.class.php';

class Produtocategoria
{
	private $bd;
	private $produtoCategoriaId;
	private $categoriaid;
	private $subcategoriaid;
	private $produtoid;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->produtoCategoriaId = '';

		$objCategoriaId = new Categoria();
		$this->categoriaid = $objCategoriaId;

		$objSubcategoriaId = new Subcategoria();
		$this->subcategoriaid = $objSubcategoriaId;

		$objProdutoId = new Produto();
		$this->produtoid = $objProdutoId;
	}

	public function setProdutoCategoriaId( $produtoCategoriaId )
	{
		$this->produtoCategoriaId = $produtoCategoriaId;
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

	public function getProdutoCategoriaId()
	{
		return $this->produtoCategoriaId;
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

	public function listarProdutocategoria( $produtoId, Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from produtocategoria ";
		$sql .= "where mProdutoId = $produtoId";
		
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
		$this->setProdutoCategoriaId( $row["produtocategoriaID"] );

		$objCategoriaId = new Categoria();
		$objCategoriaId->obterCategoria( $row["mCategoriaId"] );

		$this->setCategoriaId( $objCategoriaId );

		$objSubcategoriaId = new Subcategoria();
		$objSubcategoriaId->obterSubcategoria( $row["mSubcategoriaId"] );

		$this->setSubcategoriaId( $objSubcategoriaId );

		//$objProdutoId = new Produto();
		//$objProdutoId->obterProduto( $row["mProdutoId"] );

		//$this->setProdutoId( $objProdutoId );
	}
}
?>