<?php 

include_once "bancodedados.class.php";


class Files
{
	private $bd;
	private $id;
	private $name;
	private $size;
	private $type;
	private $url;
	private $title;
	private $description;
	private $mProdutoId;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->id = '';
		$this->name = '';
		$this->size = '';
		$this->type = '';
		$this->url = '';
		$this->title = '';
		$this->description = '';
		$this->mProdutoId = '';
	}

	public function setId( $id )
	{
		$this->id = $id;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	public function setSize( $size )
	{
		$this->size = $size;
	}

	public function setType( $type )
	{
		$this->type = $type;
	}

	public function setUrl( $url )
	{
		$this->url = $url;
	}

	public function setTitle( $title )
	{
		$this->title = $title;
	}

	public function setDescription( $description )
	{
		$this->description = $description;
	}

	public function setMProdutoId( $mProdutoId )
	{
		$this->mProdutoId = $mProdutoId;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getMProdutoId()
	{
		return $this->mProdutoId;
	}

	public function obterFiles( $filesID )
	{
		$result = $this->bd->obterRegistroPorId( "files", $filesID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarFiles( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from files ";

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
	
	public function obtemImagemPrincipal($produdoId)
	{
		$sql  = "select * ";
		$sql .= "from files " .
				"where mProdutoId = $produdoId " .
				"ORDER BY id ASC " .
				"LIMIT 1";

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarObjeto( $result->fetch_array() );
		else
			return null;
	}
	
	public function listarFileComFiltro($result = '')
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
		$this->setId( $row["id"] );
		$this->setName( $row["name"] );
		$this->setSize( $row["size"] );
		$this->setType( $row["type"] );
		$this->setUrl( $row["url"] );
		$this->setTitle( $row["title"] );
		$this->setDescription( $row["description"] );
		$this->setMProdutoId( $row["mProdutoId"] );
	}
}
?>