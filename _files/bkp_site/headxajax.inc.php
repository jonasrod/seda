<?php
  
 /*** print the javasript ***/  
 $xajax->printJavascript();
?>
<script type="text/javascript">
	
	function calculaValorQuantidadeModal(produtoId) {
		var quantidade = $("#quantidadeModal" + produtoId).val();
		xajax_calculaValorQuantidade(produtoId, quantidade);
	}
</script>