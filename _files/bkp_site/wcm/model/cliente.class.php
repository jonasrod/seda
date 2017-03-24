<?php 

include_once "bancodedados.class.php";

include_once 'genero.class.php';
include_once 'tipo_cliente.class.php';

class Cliente
{
	private $bd;
	private $clienteId;
	private $generoid;
	private $tipoclienteid;
	private $nome;
	private $sobrenome;
	private $email;
	private $senha;
	private $dtAniversario;
	private $status;
	private $dtCadastro;
	private $cpf;
	private $rg;
	private $telResidencial;
	private $telComercial;
	private $telCelular;
	private $receberNovidades;
	private $comoFicouSabendo;

	public function __construct()
	{
		$this->bd = BancodeDados::getInstance();

		$this->clienteId = '';

		$objGeneroId = new Genero();
		$this->generoid = $objGeneroId;

		$objTipoClienteId = new TipoCliente();
		$this->tipoclienteid = $objTipoClienteId;
		$this->nome = '';
		$this->sobrenome = '';
		$this->email = '';
		$this->senha = '';
		$this->dtAniversario = '';
		$this->status = '';
		$this->dtCadastro = '';
		$this->cpf = '';
		$this->rg = '';
		$this->telResidencial = '';
		$this->telComercial = '';
		$this->telCelular = '';
		$this->receberNovidades = '';
		$this->comoFicouSabendo = '';
	}

	public function setClienteId( $clienteId )
	{
		$this->clienteId = $clienteId;
	}

	public function setGeneroId( $generoid )
	{
		$this->generoid = $generoid;
	}

	public function setTipoClienteId( $tipoclienteid )
	{
		$this->tipoclienteid = $tipoclienteid;
	}

	public function setNome( $nome )
	{
		$this->nome = $nome;
	}

	public function setSobrenome( $sobrenome )
	{
		$this->sobrenome = $sobrenome;
	}

	public function setEmail( $email )
	{
		$this->email = $email;
	}

	public function setSenha( $senha )
	{
		$this->senha = $senha;
	}

	public function setDtAniversario( $dtAniversario )
	{
		$this->dtAniversario = $dtAniversario;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setDtCadastro( $dtCadastro )
	{
		$this->dtCadastro = $dtCadastro;
	}

	public function setCpf( $cpf )
	{
		$this->cpf = $cpf;
	}

	public function setRg( $rg )
	{
		$this->rg = $rg;
	}

	public function setTelResidencial( $telResidencial )
	{
		$this->telResidencial = $telResidencial;
	}

	public function setTelComercial( $telComercial )
	{
		$this->telComercial = $telComercial;
	}

	public function setTelCelular( $telCelular )
	{
		$this->telCelular = $telCelular;
	}

	public function setReceberNovidades( $receberNovidades )
	{
		$this->receberNovidades = $receberNovidades;
	}
	
	public function setComoFicouSabendo( $comoFicouSabendo )
	{
		$this->comoFicouSabendo = $comoFicouSabendo;
	}

	public function getClienteId()
	{
		return $this->clienteId;
	}

	public function getGeneroId()
	{
		return $this->generoid;
	}

	public function getTipoClienteId()
	{
		return $this->tipoclienteid;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function getSobrenome()
	{
		return $this->sobrenome;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function getDtAniversario()
	{
		return $this->dtAniversario;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getDtCadastro()
	{
		return $this->dtCadastro;
	}

	public function getCpf()
	{
		return $this->cpf;
	}

	public function getRg()
	{
		return $this->rg;
	}

	public function getTelResidencial()
	{
		return $this->telResidencial;
	}

	public function getTelComercial()
	{
		return $this->telComercial;
	}

	public function getTelCelular()
	{
		return $this->telCelular;
	}

	public function getReceberNovidades()
	{
		return $this->receberNovidades;
	}
	
	public function getComoFicouSabendo()
	{
		return $this->comoFicouSabendo;
	}

	public function obterCliente( $clienteID )
	{
		$result = $this->bd->obterRegistroPorId( "cliente", $clienteID );
		return $this->montarObjeto( $result->fetch_array() );
	}
	
	public function obterClientePorEmail( $email )
	{
		$sql = "select * from cliente where email = '$email'";
		
		$result = $this->bd->executarSQL($sql);
		return $this->montarObjeto( $result->fetch_array() );
	}

	public function listarCliente( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from cliente ";

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
	
	public function listarClienteComFiltro($result = '')
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
		$this->setClienteId( $row["clienteId"] );

		$objGeneroId = new Genero();
		$objGeneroId->obterGenero( $row["mGeneroId"] );

		$this->setGeneroId( $objGeneroId );

		$objTipoClienteId = new TipoCliente();
		$objTipoClienteId->obterTipoCliente( $row["mTipoClienteId"] );

		$this->setTipoClienteId( $objTipoClienteId );
		$this->setNome( $row["nome"] );
		$this->setSobrenome( $row["sobrenome"] );
		$this->setEmail( $row["email"] );
		$this->setSenha( $row["senha"] );
		$this->setDtAniversario( $row["dtAniversario"] );
		$this->setStatus( $row["status"] );
		$this->setDtCadastro( $row["dtCadastro"] );
		$this->setCpf( $row["cpf"] );
		$this->setRg( $row["rg"] );
		$this->setTelResidencial( $row["telResidencial"] );
		$this->setTelComercial( $row["telComercial"] );
		$this->setTelCelular( $row["telCelular"] );
		$this->setReceberNovidades( $row["receberNovidades"] );
		$this->setComoFicouSabendo($row["comoFicouSabendo"]);
	}
	
	public function autenticarUsuario($login, $senha)
    {
        $login = addslashes( $login );
        $senha = addslashes( $senha );

        $sql  = "select * ";
        $sql .= "from cliente as u ";
        $sql .= "where u.email = '" . $login . "' ";
        $sql .= "and u.senha = '" . $senha . "' ";

        $result = $this->bd->executarSQL($sql);
		
        if ( $result->num_rows == 1 )
        {
            $this->montarObjeto( $result->fetch_array() );

            $_SESSION['brw_logado'] = true;
            $_SESSION['brw_idLogin'] = $this->getClienteId();
            $_SESSION['brw_nome'] = $this->getNome();

            return true;
        }
        else
        {
            return false;
        }
    }
}
?>