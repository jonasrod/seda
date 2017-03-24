<?php
$objBd = new BancodeDados();
$objProduto = new Produto();

/***********************************************
 * Query para trazer os produtos mais vendidos *
 ***********************************************/
$sql_vendas = "select
					sum(cp.quantidade) as quantidade,
					p.produtoId,
					p.descricao,
					p.valor,		
					ct.descricao as descricaoCategoria
				from 
					venda as v
				left join carrinho  as c on v.mCarrinhoId = c.carrinhoId
				left join carrinhoproduto as cp on c.carrinhoId = cp.mCarrinhoId
				left join produto as p on cp.mProdutoId = p.produtoId
				left join subcategoria as s on s.subcategoriaId = p.mSubcategoriaId
				left join categoria as ct on ct.categoriaId = s.mCategoriaId		
				where
					v.status = 3
				and p.status = 1
				group by cp.mProdutoId
				order by quantidade DESC
				limit 3";
$result_vendas = $objBd->executarSQL($sql_vendas);
?>
<h1 class="headingfull"><span>Mais Vendidos</span></h1>
<div class="sidewidt">
 <ul class="bestseller">
 	  <?php
 	  while( $row = $result_vendas->fetch_array() ) {
 	  		$objFile = new Files();
        	$objFile->obtemImagemPrincipal($row['produtoId']);
 	  ?>
	  <li>
        <img width="50" height="50" src="produtos/fotos/<?php echo $row['produtoId'];?>/<?php echo $objFile->getName();?>">
        <a class="productname" href="produto.php?produtoId=<?=$row['produtoId']?>"> <?php echo $row['descricao'];?></a>
        <span class="procategory"><?php echo $row['descricaoCategoria'];?></span>
        <span class="price">R$ <?php echo Data::formataMoeda($row['valor']);?></span>
      </li>
      <?php
 	  }
      ?>
    </ul>
  </div>