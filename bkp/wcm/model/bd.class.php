<?php

require_once '../config.php';

class BancodeDados
{

    private $host;
    private $user;
    private $password;
    private $conexao;
    private $dbname;

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
        $this->conexao = mysql_connect($this->host, $this->user, $this->password) or die("Falha na Conexão com Banco de Dados." . mysql_errno() . " - " . mysql_error());
        mysql_select_db($this->dbname, $this->conexao) or die("Falha na Seleção do Banco de Dados.");
    }

    /**
     * Método para desconectar com Banco de Dados.
     */
    private function desconectarBD()
    {
        @mysql_close();
    }

    /**
     * Método para executar um comando SQL.
     * @param String $sql -> String código SQL
     * @return resource
     */
    public function executarSQL($sql)
    {
        $retorno = mysql_query($sql, $this->conexao) or die("Falha na execução do comando SQL. " . mysql_error());
        return $retorno;
    }

    public function obterRegistroPorId($tabela, $id)
    {
        $sql = 'select * ';
        $sql .= 'from ' . $tabela . ' ';
        $sql .= 'where ' . $tabela . 'ID = ' . $id;

        $db = new BancodeDados();

        return $db->executarSQL($sql);
    }

    /**
     * Método para inserir dados no banco
     * @param String $tabela -> nome da tabela
     * @param Array $dados -> array com os dados
     * @return case inserido retorna o id que inseriu
     */
    public function insert($tabela, $dados)
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

        $clsBd = new BancodeDados();
        $res = $clsBd->executarSQL($sql);

        $sqlUID = "select max(" . (string) $tabela . "ID) as uid from " . $tabela;
        $resUID = $clsBd->executarSQL($sqlUID);
        $rowUID = mysql_fetch_array($resUID);

        $clsBd->__destruct();

        if ($res)
            return $rowUID['uid'];
        else
            return false;
    }

    /**
     * Recebe o nome de uma tabela
     * Retorna a quantidade de registro
     * @param unknown_type $tabela
     * @return Ambigous <>
     */
    public function obterTotalRegistros($tabela)
    {
        $sql = 'select count(*) as total ';
        $sql .= 'from ' . $tabela;

        $db = new BancodeDados();
        $result = $db->executarSQL($sql);

        $row = mysql_fetch_array($result);

        return $row['total'];
    }

    /**
     * Insere dados numa tabela com chave composta
     * @param unknown_type $tabela
     * @param unknown_type $dados
     * @return boolean
     */
    public function insertChaveComposta($tabela, $dados)
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

        $clsBd = new BancodeDados();
        $res = $clsBd->executarSQL($sql);

        $clsBd->__destruct();

        if ($res)
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
        //var_dump($dados);
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


        //echo $sql;

        $clsBd = new BancodeDados();
        $res = $clsBd->executarSQL($sql);
        $clsBd->__destruct();

        if ($res)
            return true;
        else
            return false;
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

        $clsBd = new BancodeDados();
        $res = $clsBd->executarSQL($sql);
        $clsBd->__destruct();

        if ($res)
            return true;
        else
            return false;
    }

    public function deleteChaveComposta($tabela, $chave, $id)
    {
        $sql = "DELETE FROM " . $tabela . " ";
        $sql .= "WHERE ";
        $sql .= $chave . "=" . (int) $id . " ";
        //$sql .= "LIMIT 1";

        $clsBd = new BancodeDados();
        $res = $clsBd->executarSQL($sql);
        $clsBd->__destruct();

        if ($res)
            return true;
        else
            return false;
    }

    /**
     * Metodo para obter os dados no banco ou verificar se um dado existe no banco
     * @param String $tabela -> Nome da tabela
     * @param String $arrayCondicao -> Um array com as condições do select
     * @param int $limite -> quantos resultados deseja recuperar
     * @return resource
     */
    public function obterDados($tabela, $arrayCondicao, $limite = '')
    {
        $indice = 0;
        $qtdDados = count($arrayCondicao);

        $sql = "SELECT * FROM " . $tabela . " ";
        $sql .= "WHERE ";

        foreach ($arrayCondicao as $key => $valor)
        {
            $indice++;

            $sql .= $key . " = ";

            gettype($valor) == "string" ? $sql .= "'" . $valor . "'" : $sql .= $valor;

            $indice < $qtdDados ? $sql .= " AND " : $sql .= "";
        }

        if ($limite != "")
        {
            $sql .= " LIMIT " . $limite;
        }

        $resDados = $this->executarSQL($sql);
        $this->__destruct();

        if (mysql_num_rows($result) > 0)
        {
            if ($limite != "")
            {
                return mysql_fetch_object($resDados);
            } else
            {
                return $resDados;
            }
        } else
        {
            return false;
        }
    }

    /**
     * Metodo para executar uma procedure
     * O primeiro parametro deve ser o nome da procedure
     * O outros parametro devem ser os parametro da procedure
     * @return resource
     */
    public function executarProcedure()
    {
        // Resgata os parametros passados para a função
        $argList = func_get_args();
        $qtdDados = count($argList);
        (int) $indice = 0;

        $sql = "call " . $argList[0] . " ";
        $sql .= "(";

        foreach ($argList as $key => $valor)
        {
            $indice++;

            if ($key > 0)
            {
                if (gettype($valor) == "string")
                    $sql .= "'" . $valor . "'";
                else
                    $sql .= $valor;

                if ($indice < $qtdDados)
                    $sql .= ", ";
            }
        }

        $sql .= ")";

        //echo $sql;

        $res = $this->executarSQL($sql);
        return $res;
    }

}

?>