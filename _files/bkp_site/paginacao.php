<?php
/*
$sql_produtos_promocao  = "select p.* from produto as p, marca as m " .
						  "where " .
						  "		p.flLancamento = 1 " .
						  "and " .
						  "		m.marcaId = p.mMarcaId " .
						  "and " .
						  "		p.status = 1 " .
						  "and " .
						  "		p.quantidade > 0 ";
$sql_produtos_promocao .= "order by $orderBy ";
$result_produto_promocao = $objBd->executarSQL($sql_produtos_promocao);
*/
//$objPaginacao = new Paginacao($objProduto->listarProdutoComFiltro( $result_produto_promocao ), $quantidadePorPagina);

//$sql_produtos_promocao .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
//$result_produto_promocao = $objBd->executarSQL($sql_produtos_promocao);
?>
