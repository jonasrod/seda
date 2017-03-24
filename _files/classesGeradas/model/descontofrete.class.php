<?php 

include_once "bancodedados.class.php";


class Descontofrete
{
	private $bd;
	private $descontofreteId;
	private $valor_desconto;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->descontofreteId = '';
		$this->valor_desconto = '';
	}

	public function setDescontofreteId( $descontofreteId )
	{
		$this->descontofreteId = $descontofreteId;
	}

	public function setValor_desconto( $valor_desconto )
	{
		$this->valor_desconto = $valor_desconto;
	}

	public function getDescontofreteId()
	{
		return $this->descontofreteId;
	}

	public function getValor_desconto()
	{
		return $this->valor_desconto;
	}

	public function obterDescontofrete( $descontofreteID )
	{
		$result = $this->bd->obterRegistroPorId( "descontofrete", $descontofreteID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarDescontofrete( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from descontofrete ";

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
		$this->setDescontofreteId( $row["descontofreteId"] );
		$this->setValor_desconto( $row["valor_desconto"] );
	}
}
?>