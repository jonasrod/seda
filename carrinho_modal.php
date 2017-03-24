<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
  <div class="modal-header">
    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
    <h3 id="myModalLabel">Meu Carrinho</h3>
  </div>
  <div class="modal-body">
    <table class="table table-striped">
      <tbody>
        <tr>
          <th class="image">Foto</th>
          <th class="name">Nome do Produto</th>
          <th class="quantity">Quantidade</th>
          <th class="price">Valor Unit&aacute;rio</th>
          <th class="total">Total</th>
          <th class="quantity">&nbsp;</th>
        </tr>
        <?php
        if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
        	
        	$objBd = new BancodeDados();
	        $objProduto = new Produto();
	        
	        $sql_in = "(";
	        foreach($_SESSION['carrinho'] as $produto_carrinho) {
	        	$sql_in .= $produto_carrinho['produto'] . ',';
	        }
	        $sql_in = substr($sql_in,0, -1);
	        
	        $sql_in .= ")";
	        
	        $sql_produtos_carrinho = "select * from produto where produtoId in $sql_in";
			$result_produto_carrinho = $objBd->executarSQL($sql_produtos_carrinho);
			
			$valor_total_carrinho = 0;
			$valor_total_itam     = 0;
			
	        foreach($objProduto->listarCategoriaComFiltro( $result_produto_carrinho ) as $produto) {
	        	$objFile = new Files();
        		$objFile->obtemImagemPrincipal($produto->getProdutoId());
        		
	        	$valor_total_item = $produto->getValor() * $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'];
	        	
	        	$valor_total_carrinho = $valor_total_carrinho + $valor_total_item;
	        ?>
	        <tr>
	          <td class="image"><a href="#"><img width="50" height="50" src="produtos/fotos/<?php echo $produto->getProdutoId();?>/<?php echo $objFile->getName();?>"></a>
	          <td class="name"><a href="#"><?php echo $produto->getTitulo();?></a></td>
	          <td class="quantity"><input type="text" class="span1" name="quantidadeModal" id="quantidadeModal<?php echo $produto->getProdutoId();?>" value="<?php echo $_SESSION['carrinho'][$produto->getProdutoId()]['quantidade'];?>" size="1" onBlur="calculaValorQuantidadeModal(<?php echo $produto->getProdutoId();?>)"></td>
	          <td class="price">R$<?php echo Data::formataMoeda($produto->getValor());?></td>
	          <td class="total" id="valorTotalProdutoModal<?php echo $produto->getProdutoId();?>">R$<?php echo Data::formataMoeda($valor_total_item);?></td>
	          <td class="quantity"><a href="delcarrinho.php?produtoId=<?php echo $produto->getProdutoId();?>"><img alt="" src="images/remove.png" data-original-title="Remove" class="tooltip-test"></a></td>
	        </tr>
	        <?php
	        }
	        ?>
	        <tr>
	          <td class="image" colspan="6"><h4 class="pull-right margin-none"><div id="valorTotalCarrinhoModal">Total: R$<?php echo Data::formataMoeda($valor_total_carrinho);?></div></h4></td>
	        </tr>
        	<?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button data-dismiss="modal" class="btn">Continuar Comprando</button>
    <a class="btn btn-primary" href="fechamento-pedido.php">Fechar Pedido</a>
  </div>
</div>