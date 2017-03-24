<?php 

include_once "bancodedados.class.php";


class DescontoFrete
{
	private $bd;
	private $descontoFreteId;
	private $valorDesconto;
	
	public function __construct(BancodeDados $bdParam = null)
	{
		if ($bdParam == null) {
			$this->bd = BancodeDados::getInstance();
		} else {
			$this->bd = $bdParam;
		}

		$this->descontoFreteId = '';
		$this->valorDesconto= 0;
	}

	/**
	 * @return string
	 */
	public function getDescontoFreteId()
	{
		return $this->descontoFreteId;
	}

	/**
	 * @param string $descontoFreteId
	 */
	public function setDescontoFreteId($descontoFreteId)
	{
		$this->descontoFreteId = $descontoFreteId;
	}

	/**
	 * @return int
	 */
	public function getValorDesconto()
	{
		return $this->valorDesconto;
	}

	/**
	 * @param int $valorDesconto
	 */
	public function setValorDesconto($valorDesconto)
	{
		$this->valorDesconto = $valorDesconto;
	}

	public function obterDescontoFrete( $descontoFreteID )
	{
		$result = $this->bd->obterRegistroPorId( "descontofrete", $descontoFreteID );
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function getDescontoFrete()
	{
		$sql  = "select * ";
		$sql .= "from descontofrete ";

		$result = $this->bd->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarObjeto( $result->fetch_array() );
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
			}
			return $obj;
		}
		else
		{
			return false;
		}
	}

	private function montarObjeto( $row )
	{
		$this->setDescontoFreteId($row["descontofreteId"]);
		$this->setValorDesconto($row["valor_desconto"]);
	}
}
?>