<?php

include_once '../../wcm/model/classesGeradas/model/produto.class.php';
include_once '../model/marcaid.class.php';

$objMarcaId = new MarcaId();
$objProduto = new Produto();

$action = "inserirProduto";

if( isset( $_GET["idProduto"] ) )
{
	$action = "editarProduto";
	$objProduto->obterProduto( $_GET["idProduto"] );
}

?>

<script src="../js/jquery.validate.min.js"></script>

<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/produto-controle.php"  class="form-inline">

<p><a href="index.php?cmd=produto-lista" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="idProduto" value="<?=$objProduto->getProdutoID()?>" />

<div class="control-group">
	<label class="control-label span3" for="produtoId">ProdutoId</label> 
	<input type="text" name="produtoId" id="produtoId"  class="span9" required="true" value="<?=$objProduto->getProdutoId()?>" />
</div>

<div class="control-group">
	<label for="marcaid" class="control-label span3">MarcaId</label>
	<select name="marcaid" id="marcaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a marcaid</option>
	<?php foreach( $objMarcaId->listarMarcaId() as $marcaid ) { ?>
		<option value="<?=$marcaid->getMarcaIdID()?>" <?php if( $marcaid->getMarcaIdID() == $objProduto->getMarcaId()->getMarcaIdID() ){ ?>selected="selected"<?php } ?>>
		<?=$marcaid->getDescricao()?></option>
	<?php } ?>
	</select>
</div>

<div class="control-group">
	<label class="control-label span3" for="mSubcategoriaId">MSubcategoriaId</label> 
	<input type="text" name="mSubcategoriaId" id="mSubcategoriaId"  class="span9" required="true" value="<?=$objProduto->getMSubcategoriaId()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="codigoProduto">CodigoProduto</label> 
	<input type="text" name="codigoProduto" id="codigoProduto"  class="span9" required="true" value="<?=$objProduto->getCodigoProduto()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="titulo">Titulo</label> 
	<input type="text" name="titulo" id="titulo"  class="span9" required="true" value="<?=$objProduto->getTitulo()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?=$objProduto->getDescricao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtCadastro">DtCadastro</label> 
	<input type="text" name="dtCadastro" id="dtCadastro"  class="span9" required="true" value="<?=$objProduto->getDtCadastro()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="dtAutualizacao">DtAutualizacao</label> 
	<input type="text" name="dtAutualizacao" id="dtAutualizacao"  class="span9" required="true" value="<?=$objProduto->getDtAutualizacao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="status">Status</label> 
	<input type="text" name="status" id="status"  class="span9" required="true" value="<?=$objProduto->getStatus()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valor">Valor</label> 
	<input type="text" name="valor" id="valor"  class="span9" required="true" value="<?=$objProduto->getValor()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valorOriginal">ValorOriginal</label> 
	<input type="text" name="valorOriginal" id="valorOriginal"  class="span9" required="true" value="<?=$objProduto->getValorOriginal()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidade">Quantidade</label> 
	<input type="text" name="quantidade" id="quantidade"  class="span9" required="true" value="<?=$objProduto->getQuantidade()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidadeMinima">QuantidadeMinima</label> 
	<input type="text" name="quantidadeMinima" id="quantidadeMinima"  class="span9" required="true" value="<?=$objProduto->getQuantidadeMinima()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="peso">Peso</label> 
	<input type="text" name="peso" id="peso"  class="span9" required="true" value="<?=$objProduto->getPeso()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="destaque">Destaque</label> 
	<input type="text" name="destaque" id="destaque"  class="span9" required="true" value="<?=$objProduto->getDestaque()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="informacao">Informacao</label> 
	<input type="text" name="informacao" id="informacao"  class="span9" required="true" value="<?=$objProduto->getInformacao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="desconto">Desconto</label> 
	<input type="text" name="desconto" id="desconto"  class="span9" required="true" value="<?=$objProduto->getDesconto()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="flPromocao">FlPromocao</label> 
	<input type="text" name="flPromocao" id="flPromocao"  class="span9" required="true" value="<?=$objProduto->getFlPromocao()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="flLancamento">FlLancamento</label> 
	<input type="text" name="flLancamento" id="flLancamento"  class="span9" required="true" value="<?=$objProduto->getFlLancamento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="altura">Altura</label> 
	<input type="text" name="altura" id="altura"  class="span9" required="true" value="<?=$objProduto->getAltura()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="largura">Largura</label> 
	<input type="text" name="largura" id="largura"  class="span9" required="true" value="<?=$objProduto->getLargura()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="comprimento">Comprimento</label> 
	<input type="text" name="comprimento" id="comprimento"  class="span9" required="true" value="<?=$objProduto->getComprimento()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="tamanho">Tamanho</label> 
	<input type="text" name="tamanho" id="tamanho"  class="span9" required="true" value="<?=$objProduto->getTamanho()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="infotecnica">Infotecnica</label> 
	<input type="text" name="infotecnica" id="infotecnica"  class="span9" required="true" value="<?=$objProduto->getInfotecnica()?>" />
</div>

</form>
</div>
</div>