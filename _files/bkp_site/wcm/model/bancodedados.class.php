<?php
class BancodeDados
{
    private $host;
    private $user;
    private $password;
    private $dbname;
    public $mysqli;
    public $insert_id;
    
    private static $instance;

    /**
     * Configura as variaveis da classe com
     * as constantes do arquivo config
     */
    public function __construct()
    {
        $this->host = DB_SERVER;
        $this->user = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;
        $this->conectarBD();
    }
    
    public static function getInstance() {
		if (!isset(self::$instance) && is_null(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		 
		return self::$instance;
	}
    

    /**
     * Destrutor da Classe.
     */
    public function __destruct()
    {
        $this->desconectarBD();
    }

    /**
     * M�todo para conectar com Banco de Dados.
     * Este m�todo � executado no construtor
     */
    private function conectarBD()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->dbname);
		$this->mysqli->set_charset("utf8");
        if ( $this->mysqli->connect_errno )
        {
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }

        $this->mysqli->autocommit(false);
    }

    /**
     * M�todo para desconectar com Banco de Dados.
     */
    private function desconectarBD()
    {
        $this->mysqli->close();
    }

    /**
     * M�todo para executar um comando SQL.
     * @param String $sql -> String c�digo SQL
     * @return resource
     */
    public function executarSQL( $sql )
    {
        if (!$result = $this->mysqli->query($sql))
        {
            echo "Query: $sql<br>";
            echo $this->mysqli->error;
            $this->mysqli->rollback();
		    $this->mysqli->close();
		    exit();
		}
        else
        {
            //$this->commit();
            return $result;
        }
    }

    /**
     * Descricao do metodo
     */
    public function commit()
    {
        $this->mysqli->commit();
    }

    /**
     * Descricao do metodo
     */
    public function rollback()
    {
        $this->mysqli->rollback();
    }
    
    /**
     * Retorna a ultima mensagem de erro
     */
     public function error() {
     	return $this->mysqli->error; 
     }

    /**
     * Descricao do metodo
     * @param type $tabela
     * @param type $id
     * @return type
     */
    public function obterRegistroPorId($tabela, $id)
    {
        $sql  = 'select * ';
        $sql .= 'from ' . $tabela . ' ';
        $sql .= 'where ' . $tabela . 'Id = ' . $id;
        return $this->executarSQL( $sql );
    }

    /**
     * M�todo para inserir dados no banco
     * @param String $tabela -> nome da tabela
     * @param Array $dados -> array com os dados
     * @return case inserido retorna o id que inseriu
     */
    public function insert( $tabela, $dados )
    {
        // Monta um array com as chaves do array dados
        $keys = array_keys($dados);
        $qtdDados = count($dados);
        (int) $indice = 0;

        $sql = "INSERT INTO " . $tabela . " (";
        for ($i = 0; $i < count($keys); $i++)
        {
            $sql .= $keys[$i];
            if ($i < (count($dados) - 1))
                $sql .= ",";
        }

        $sql .= ") VALUES (";

        foreach ($dados as $valor)
        {
            $indice++;

            if ($valor == null || $valor == 'null' || $valor == 'NULL')
                $sql .= 'null';
            else
                $sql .= "'" . $valor . "'";

            if ($indice < $qtdDados)
                $sql .= ",";
        }

        $sql .= ")";
        
        $result = $this->executarSQL( $sql );
        $this->insert_id = $this->mysqli->insert_id;
        if( $result )
        {/*
            $sqlUID = "select max(" . (string) $tabela . "ID) as uid from " . $tabela;
            $resUID = $this->executarSQL($sqlUID);
            $rowUID = $resUID->fetch_array();
            $resUID->close();

            if ( $rowUID ) {
                return $rowUID['uid'];
            } else {
            	return false;
            }
           */return true;     
        }
        else
        {
            return false;
        }
    }

    /**
     * Recebe o nome de uma tabela
     * Retorna a quantidade de registro
     * @param unknown_type $tabela
     * @return Ambigous <>
     */
    public function obterTotalRegistros($tabela)
    {
        $sql  = 'select count(*) as total ';
        $sql .= 'from ' . $tabela;

        $result = $this->executarSQL($sql);

        $row = $result->fetch_array();
        $result->close();
        
        return $row['total'];
    }

    /**
     * Insere dados numa tabela com chave composta
     * @param unknown_type $tabela
     * @param unknown_type $dados
     * @return boolean
     */
    public function insertCompositeKey( $tabela, $dados )
    {
        // Monta um array com as chaves do array dados
        $keys = array_keys($dados);
        $qtdDados = count($dados);
        (int) $indice = 0;

        $sql = "INSERT INTO " . $tabela . " (";
        for ($i = 0; $i < count($keys); $i++)
        {
            $sql .= $keys[$i];
            if ($i < (count($dados) - 1))
                $sql .= ",";
        }

        $sql .= ") VALUES (";

        foreach ($dados as $valor)
        {
            $indice++;

            if ($valor == null || $valor == 'null' || $valor == 'NULL')
                $sql .= 'null';
            else
                $sql .= "'" . $valor . "'";

            if ($indice < $qtdDados)
                $sql .= ",";
        }

        $sql .= ")";
        
        $result = $this->executarSQL( $sql );
        
        if ( $result )
            return true;
        else
            return false;
    }

    /**
     * Atualiza os dados no banco
     * @param Strig $tabela -> Nome da tabela
     * @param Array $dados -> Array com os dados
     * @param Int $id -> ID a ser alterado
     * @return boolean
     */
    public function edit($tabela, $dados, $id = null)
    {
        $keys = array_keys($dados);
        $qtdDados = count($dados);
        (int) $indice = 0;

        $sql = "UPDATE " . $tabela . " ";
        $sql .= "SET ";

        foreach ($dados as $keys => $valor)
        {
            $indice++;
            if (gettype($valor) == "string")
                $sql .= $keys . "='" . $valor . "' ";
            else if ($valor == null || $valor == 'null' || $valor == 'NULL')
                $sql .= $keys . "=NULL ";
            else
                $sql .= $keys . "=" . $valor . " ";

            if ($indice < $qtdDados)
                $sql .= ", ";
        }
		if ($id != null) {
			$sql .= "WHERE ";
        	$sql .= $tabela . "ID=" . (int) $id . " ";
		}
        $sql .= "LIMIT 1";

        $result = $this->executarSQL($sql);
        
        if( $result )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Deleta uma linha no banco
     * @param String $tabela -> Nome da tabela
     * @param Int $id -> ID da linha a ser deletada
     * @return boolean
     */
    public function delete($tabela, $id)
    {
        $sql = "DELETE FROM " . $tabela . " ";
        $sql .= "WHERE ";
        $sql .= $tabela . "ID=" . (int) $id . " ";
        $sql .= "LIMIT 1";

        $result = $this->executarSQL($sql);
        
        if( $result )
        {
            return true;
        }
        else
        {
            return false;
        }

    }
    
    /**
     * Deleta uma linda de tabela com chave composta
     * @param type $tabela
     * @param type $chave
     * @param type $id
     * @return boolean
     */
    public function deleteCompositeKey($tabela, $chave, $id)
    {
        $sql  = "DELETE FROM " . $tabela . " ";
        $sql .= "WHERE ";
        $sql .= $chave . "=" . (int) $id . " ";
        
        $result = $this->executarSQL($sql);
        
        if( $result )
            return true;
        else
            return false;
    }

}

?>