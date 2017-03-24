<?php

/**
 * Data de atualização 19/06/2013
 * Exemplo de como implementar a classe paginacao
 * 
 * -------------------------------
 * Pagina onde estará a lista
 * -------------------------------
 * 
 * $objExemplo = new Exemplo();
 * $objPaginacao = new Paginacao( $objEmpresa->listarExemplo(), 4 );
 * 
 * foreach( $objExemplo->listarExemplo( $objPaginacao ) as $obj ){ echo $obj->getItem(); }
 * 
 * -------------------------------
 * Método listar
 * -------------------------------
 * public function listarExemplo( Paginacao $objPaginacao = null )
 * {
 * 		if( $objPaginacao )
 * 			$sql .= 'limit ' . $objPaginacao->getInicio() .','.$objPaginacao->getResultPorPagina().' ';
 *  
 * 	continuação do método......
 */
class Paginacao
{

    private $resultPorPagina;
    private $pagina;
    private $menos;
    private $mais;
    private $pgs;
    private $inicio;
    private $html;
    private $metodo;

    /**
     * Enter description here ...
     * @param unknown_type $paginaAtual
     * @param unknown_type $metodoListar
     * @param unknown_type $resultPorPagina
     */
    public function __construct($metodoListar, $resultPorPagina)
    {
        isset($_GET['p']) ? $pgAtual = $_GET['p'] : $pgAtual = 1;

        $this->setResultPorPagina($resultPorPagina);
        $this->metodo = $metodoListar;
        $this->pagina = $pgAtual;
        $this->html = '';
        $this->montarPaginacao();
    }

    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }

    public function getInicio()
    {
        return $this->inicio;
    }

    public function setResultPorPagina($resultPorPagina)
    {
        $this->resultPorPagina = $resultPorPagina;
    }

    public function getResultPorPagina()
    {
        return $this->resultPorPagina;
    }
    
    public function drawPaginacao()
    {
        echo $this->html;
    }
    
    /**
     * Enter description here ...
     * @param unknown_type $total
     */
    private function montarPaginacao()
    {
        $this->html = '';
        // Calculando o registro inicial
        $this->inicio = $this->pagina - 1;
        $this->inicio = $this->getResultPorPagina() * $this->inicio;

        $this->menos = ( $this->pagina ) - 1;
        $this->mais = ( $this->pagina ) + 1;

        $this->pgs = ceil(count($this->metodo) / $this->getResultPorPagina());

        $qs = explode("&", $_SERVER['QUERY_STRING']);

        if ($this->pgs > 1)
        {
            $this->html .= '<div class="pagination" align="center"><ul>';

            $queryString = '';

            foreach ($qs as $valor)
            {
                // Verifica se j� existe a variavel "p" para n�o acumular na url
                if (substr($valor, 0, 2) != 'p=')
                    $queryString .= $valor . '&';
            }

            if ($this->menos > 0)
            {
                $this->html .= '<li><a href=' . $_SERVER['PHP_SELF'] . '?' . $queryString . 'p=' . $this->menos . '>&laquo;</a></li>';
            } else
            {
                $this->html .= '<li class="disabled"><a href="#">&laquo;</a></li>';
            }

            for ($i = 1; $i <= $this->pgs; $i++)
            {
                if ($i != $this->pagina)
                {
                    $this->html .= '<li><a href=' . $_SERVER['PHP_SELF'] . '?' . $queryString . 'p=' . $i . '>' . $i . '</a></li>';
                } else
                {
                    $this->html .= '<li class="active"><a href="#">' . $i . '</a></li>';
                }
            }

            if ($this->mais <= $this->pgs)
            {
                $this->html .= '<li><a href=' . $_SERVER['PHP_SELF'] . '?' . $queryString . 'p=' . $this->mais . '>&raquo;</a></li>';
            } else
            {
                $this->html .= '<li class="disabled"><span>&raquo;</span></li>';
            }

            $this->html .= '</ul></div>';

            //echo $this->html;
        }
    }

}

?>