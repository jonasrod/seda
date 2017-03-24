<?php

require_once '../config.php';

class BancodeDados
{
    private $host;
    private $user;
    private $password;
    private $dbname;
    public $mysqli;

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

    /**
     * Destrutor da Classe.
     */
    public function __destruct()
    {
        $this->desconectarBD();
    }

    /**
     * Método para conectar com Banco de Dados.
     * Este método é executado no construtor
     */
    private function conectarBD()
    {
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ( $this->mysqli->connect_errno )
        {
            die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }

        $this->mysqli->autocommit(false);
    }

    /**
     * Método para desconectar com Banco de Dados.
     */
    private function desconectarBD()
    {
        $this->mysqli->close();
    }

    /**
     * Método para executar um comando SQL.
     * @param String $sql -> String código SQL
     * @return resource
     */
    public function executarSQL( $sql )
    {
        if (!$result = $this->mysqli->query($sql))
        {
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
     * Descricao do metodo
     * @param type $tabela
     * @param type $id
     * @return type
     */
    public function obterRegistroPorId($tabela, $id)
    {
        $sql  = 'select * ';
        $sql .= 'from ' . $tabela . ' ';
        $sql .= 'where ' . $tabela . 'ID = ' . $id;

        return $this->executarSQL( $sql );
    }

    /**
     * Método para inserir dados no banco
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
        
        if( $result )
        {
            $sqlUID = "select max(" . (string) $tabela . "ID) as uid from " . $tabela;
            $resUID = $this->executarSQL($sqlUID);
            $rowUID = $resUID->fetch_array();
            $resUID->close();

            if ( $rowUID )
                return $rowUID['uid'];
            else
                return false;
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
    public function edit($tabela, $dados, $id)
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