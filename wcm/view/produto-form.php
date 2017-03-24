<?php

include_once '../model/produto.class.php';
include_once '../model/marca.class.php';
include_once '../model/categoria.class.php';
include_once '../model/subcategoria.class.php';
include_once '../model/produtosequence.class.php';
include_once '../model/data.class.php';
include_once '../model/alerta.class.php';

$objMarcaId = new Marca();
$objCategoria = new Categoria();
$objSubcategoriaId = new Subcategoria();
$objProduto = new Produto();
$objSequence = new Produtosequence();
$objData = new Data();

$action = "inserirProduto";

if( isset( $_GET["idProduto"] ) )
{
	$action = "editarProduto";
	$objProduto->obterProduto( $_GET["idProduto"] );
	$_SESSION['produto-form']['idProdutoInsert'] = $_GET["idProduto"];
} else {
	
	if (!isset($_SESSION['produto-form']['idProdutoInsert']) 
		|| (isset($_SESSION['produto-form']['idProdutoInsert']) && $_SESSION['produto-form']['idProdutoInsert'] == 0)) {
		$_SESSION['produto-form']['idProdutoInsert'] = $objSequence->getLastID();
	}
}

?>

<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.3.js"></script>
<script type="text/javascript" src="../js/jquery.maskMoney.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$("#desconto").maskMoney({prefix:'% ', allowNegative: true, thousands:'.', decimal:'.', affixesStay: false});
		
		validaFotos();
	});
	
	function validaFotos() {
		var rowsCount = document.getElementById("tabelUpload").rows.length;
	
		if (rowsCount == 3) {
			//document.getElementById("btnUpload").style.display = 'none';
			$("#btnUpload").toggleClass("disableUpload");
		} else {
			//document.getElementById("btnUpload").style.display = 'block';
			//$("#btnUpload").toggleClass("enableUpload");
		}
		
	}
	
	function habilitaUpload() {
		$("#btnUpload").removeClass("disableUpload");
	}
	
	var trIndex = 0;
	function appendCategoria() {
		var valorHidden = "";
		
		var categoria = $("#categoria :selected").text();
		var categoriaId = $("#categoria").val();
		var subcategoria = $("#subcategoriaid :selected").text();
		var subcategoriaId = $("#subcategoriaid").val();
		
		
		if (categoria == "Selecione") {
			alert("Selecione uma Categoria");
			return false;
		}
		
		if (subcategoria == "Selecione") {
			alert("Selecione uma Subcategoria");
			return false;
		}
		
		var valorHidden = categoriaId + "|" + subcategoriaId;
		
		for (i = 0; i < trIndex; i++) {
			var hidden = $("#hidden"+i).val();
			if (hidden == valorHidden) {
				alert('Categoria/Subcategoria já incluída!');
				return false;
			}
		}
		
		var htmlHidden = '<input type="hidden" name="dadosCategoria[]" id="hidden'+trIndex+'" value="'+valorHidden+'" />';
	    var html = "<tr id='tr"+trIndex+"'><td>"+categoria+"</td><td>"+subcategoria+"</td><td><i class='icon-trash' style='cursor: pointer' onclick='removeCategoria("+trIndex+")'></i>"+htmlHidden+"</td></tr>";
	    $("#tabelaCategoria").append(html);
	    trIndex++;
	    
	    $("#categoria").attr('selectedIndex', 0);
	    $("#subcategoriaid").attr('selectedIndex', 0);
	    
	    getSubcategoria();
	}
	
	function removeCategoria(indexToRemove) {
		$("#tr" + indexToRemove).remove();
		$("#hidden" + indexToRemove).remove();
	}


	var trIndexMedida = 0;
	function appendMedida() {
		var valorHidden = "";
		
		var medida = $("#medida").val();
		var medidaQuantidade = $("#medidaQuantidade").val();
		
		
		if (medida == "Selecione") {
			alert("Selecione uma Medida");
			return false;
		}
		
		if (medidaQuantidade === undefined || medidaQuantidade == "" || medidaQuantidade == null) {
			alert("Preencha a Quantidade");
			return false;
		}
		
		var valorHidden = medida + "|" + medidaQuantidade;
		
		for (i = 0; i < trIndexMedida; i++) {
			var hidden = $("#hiddenMedida"+i).val();
			if (hidden == valorHidden) {
				alert('Medida já incluída!');
				return false;
			}
		}
		
		var htmlHidden = '<input type="hidden" name="dadosMedida[]" id="hiddenMedida'+trIndexMedida+'" value="'+valorHidden+'" />';
	    var html = "<tr id='trMedida"+trIndexMedida+"'><td>"+medida+"</td><td>"+medidaQuantidade+"</td><td><i class='icon-trash' style='cursor: pointer' onclick='removeMedida("+trIndexMedida+")'></i>"+htmlHidden+"</td></tr>";
	    $("#tabelaMedida").append(html);
	    trIndexMedida++;
	    
	    $("#medida").attr('selectedIndex', 0);
	    $("#medidaQuantidade").val = '';
	}

	function removeMedida(indexToRemove) {
		$("#trMedida" + indexToRemove).remove();
		$("#hiddenMedida" + indexToRemove).remove();
	}

</script>
<div class="span12">
<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
</div>
<div class="span6">
<div class="row-fluid">
<form id="form1" name="form1" method="post" action="../controller/produto-controle.php"  class="form-inline">

<p><a href="../controller/produto-controle.php?action=voltar&type=<?php echo $action;?>" class="btn btn-info">&lt;&lt; Voltar</a>
<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>

<input type="hidden" name="action" value="<?php echo $action;?>" />
<input type="hidden" name="idProduto" value="<?php echo $objProduto->getProdutoId();?>" />
<input type="hidden" name="idProdutoInsert" value="<?php echo $_SESSION['produto-form']['idProdutoInsert'];?>" />

<div class="control-group">
	<label for="marcaid" class="control-label span3">Marca</label>
	<select name="marcaid" id="marcaid" class="span9" required="true">
	<option value="" disabled="disabled" selected="selected">Selecione a marca</option>
	<?php foreach( $objMarcaId->listarMarca() as $marcaid ) { ?>
		<option value="<?php echo $marcaid->getMarcaId();?>" <?php if( $marcaid->getMarcaId() == $objProduto->getMarcaId()->getMarcaId() ){ ?>selected="selected"<?php } ?>><?php echo $marcaid->getDescricao();?></option>
	<?php } ?>
	</select>
</div>

<fieldset>
	<legend class="scheduler-border">Categoria</legend>
	<div class="control-group">
		<label for="categoria" class="control-label span3">Categoria</label>
		<select name="categoria" id="categoria" class="span9" required="true" onChange="getSubcategoria()">
		<option value="0" disabled="disabled" selected="selected">Selecione</option>
		<?php foreach( $objCategoria->listarCategoria() as $categoria ) { ?>
			<option value="<?php echo $categoria->getCategoriaId();?>" <?php if( $categoria->getCategoriaId() == $objProduto->getSubcategoriaId()->getCategoriaId()->getCategoriaId() ){ ?>selected="selected"<?php } ?>><?php echo $categoria->getDescricao();?></option>
		<?php } ?>
		</select>
	</div>
	
	<div class="control-group">
		<label for="subcategoriaid" class="control-label span3">Subcategoria</label>
		<select name="subcategoriaid" id="subcategoriaid" class="span9" required="true">
		<option value="0" disabled="disabled" selected="selected">Selecione</option>
		<?php foreach( $objSubcategoriaId->listarSubcategoria() as $subcategoriaid ) { ?>
			<option value="<?php echo $subcategoriaid->getSubcategoriaId();?>" <?php if( $subcategoriaid->getSubcategoriaId() == $objProduto->getSubcategoriaId()->getSubcategoriaId() ){ ?>selected="selected"<?php } ?>>
			<?php echo $subcategoriaid->getDescricao();?></option>
		<?php } ?>
		</select>
	</div>
	<div class="control-group">
		<label class="control-label span3" for="btnIncluirCategoria">&nbsp;</label> 
		<button class="btn btn-mini btn-primary" id="btnIncluirCategoria" type="button" onClick="appendCategoria()">Incluir</button>
	</div>
</fieldset>
<fieldset id="fieldset">
	<legend class="scheduler-border"></legend>
</fieldset>
<div class="control-group">
    <div class="controls">
      	<table class="table table-striped" id="tabelaCategoria">
			<tr>
				<th>Categoria</th>
				<th>Subcategoria</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			$i = 100; // pra nao conflitar com os indices gerados pelo javascript que comeca do zero
        	foreach($objProduto->getListaCategorias() as $produtoCategoria) {
        		echo '<tr id="tr'.$i.'">';
        		echo '<td>'.$produtoCategoria->getCategoriaid()->getDescricao().'</td>';
        		echo '<td>'.$produtoCategoria->getSubcategoriaId()->getDescricao().'</td>';
        		echo '<td><i class="icon-trash" style="cursor: pointer" onclick="removeCategoria('.$i.')"></i>';
        		echo '<input type="hidden" name="dadosCategoria[]" id="hidden'.$i.'" value="'.$produtoCategoria->getCategoriaid()->getCategoriaId().'|'.$produtoCategoria->getSubcategoriaId()->getSubcategoriaId().'" />';
        		echo '</td>';
        		echo '</tr>';
        		$i++;
        	}
        	?>
		</table>
    </div>
</div>
<fieldset id="fieldset">
	<legend class="scheduler-border"></legend>
</fieldset>

<div class="control-group">
	<label class="control-label span3" for="codigoProduto">Codigo Produto</label> 
	<input type="text" name="codigoProduto" id="codigoProduto"  class="span9" required="true" value="<?php echo $objProduto->getCodigoProduto();?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">T&iacute;tulo</label> 
	<input type="text" name="titulo" id="titulo"  class="span9" required="true" value="<?php echo $objProduto->getTitulo();?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="descricao">Descricao</label> 
	<input type="text" name="descricao" id="descricao"  class="span9" required="true" value="<?php echo $objProduto->getDescricao();?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="valor">Valor</label> 
	<input type="text" name="valor" id="valor"  class="span9" required="true" value="<?php echo $objData->formataMoeda($objProduto->getValorOriginal());?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidade">Quantidade</label> 
	<input type="text" name="quantidade" id="quantidade"  class="span9" required="true" value="<?php echo $objProduto->getQuantidade();?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="quantidadeMinima">Quantidade Minima</label> 
	<input type="text" name="quantidadeMinima" id="quantidadeMinima"  class="span9" required="true" value="<?php echo $objProduto->getQuantidadeMinima();?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="peso">Peso(Kg/ml)</label> 
	<input type="text" name="peso" id="peso"  class="span9" required="true" value="<?php echo $objProduto->getPeso();?>" />
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
	<input type="text" name="tamanho" id="tamanho"  class="span9" value="<?=$objProduto->getTamanho()?>" />
</div>

<div class="control-group">
	<label class="control-label span3" for="informacao">Informa&ccedil;&atilde;o</label>
	<textarea name="informacao" class="span9" wrap="off" required="true"><?php echo Data::br2nl($objProduto->getInformacao());?></textarea>
</div>

<div class="control-group">
	<label class="control-label span3" for="infotecnica">Info. T&eacute;cnica</label>
	<textarea name="infotecnica" class="span9" wrap="off"><?php echo $objProduto->getInfotecnica();?></textarea>
</div>

<div class="control-group">
	<label class="control-label span3" for="desconto">Desconto %</label> 
	<input type="text" name="desconto" id="desconto"  class="span9" value="<?php echo $objProduto->getDesconto();?>" />
</div>

<div class="control-group">
	<label for="categoria" class="control-label span3">Medida</label>
	<select name="medida" id="medida" class="span9" required="true">
	<option value="0" disabled="disabled" selected="selected">Selecione</option>
		<option value="P">P</option>
		<option value="M">M</option>
		<option value="G">G</option>
		<option value="GG">GG</option>
		<option value="48">48</option>
		<option value="50">50</option>
		<option value="52">52</option>
		<option value="54">54</option>
	</select>
</div>

<div class="control-group">
	<label for="subcategoriaid" class="control-label span3">Quantidade</label>
	<input type="text" name="medidaQuantidade" id="medidaQuantidade"  class="span9" />
</div>
<div class="control-group">
	<label class="control-label span3" for="btnIncluirCategoria">&nbsp;</label> 
	<button class="btn btn-mini btn-primary" id="btnIncluirCategoria" type="button" onClick="appendMedida()">Incluir</button>
</div>
<div class="control-group">
    <div class="controls">
      	<table class="table table-striped" id="tabelaMedida">
			<tr>
				<th>Medida</th>
				<th>Quantidade</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			$i = 100; // pra nao conflitar com os indices gerados pelo javascript que comeca do zero
        	foreach($objProduto->getListaMedidas() as $produtoMedida) {
        		echo '<tr id="tr'.$i.'">';
        		echo '<td>'.$produtoMedida->getMedida().'</td>';
        		echo '<td>'.$produtoMedida->getQuantidade().'</td>';
        		echo '<td><i class="icon-trash" style="cursor: pointer" onclick="removeCategoria('.$i.')"></i>';
        		echo '<input type="hidden" name="dadosMedida[]" id="hidden'.$i.'" value="'.$produtoMedida->getMedida().'|'.$produtoMedida->getQuantidade().'" />';
        		echo '</td>';
        		echo '</tr>';
        		$i++;
        	}
        	?>
		</table>
    </div>
</div>
<br />
<div class="control-group">
	Destaque 
	<input type="checkbox"  name="destaque" id="destaque" value="1" <?php echo ($objProduto->getDestaque() == 1) ? 'checked="true"' : '';?>/>&nbsp;&nbsp;&nbsp;
	Promo&ccedil;&atilde;o
	<input type="checkbox" name="flPromocao" id="flPromocao" value="1" <?php echo ($objProduto->getFlPromocao() == 1) ? 'checked="true"' : '';?>/>&nbsp;&nbsp;&nbsp;
	Lan&ccedil;amento
	<input type="checkbox" name="flLancamento" id="flLancamento" value="1" <?php echo ($objProduto->getFlLancamento() == 1) ? 'checked="true"' : '';?>/>
</div>

</form>
</div>
</div>

<div class="span6">
<div class="row-fluid">
	<form id="fileupload" action="server/php/index.php" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-7">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button" id="btnUpload">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Adicionar arquivos...</span>
                <input type="file" name="files[]" onChange="validaFotos()">
            </span>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Iniciar upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel" onClick="habilitaUpload()">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancelar upload</span>
            </button>
            <button type="button" class="btn btn-danger delete" onClick="habilitaUpload()">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
            </button>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="col-lg-5 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped" id="tabelUpload"><tbody class="files"></tbody></table>
	</form>
	
	<!-- The blueimp Gallery widget -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	    <div class="slides"></div>
	    <h3 class="title"></h3>
	    <a class="prev">‹</a>
	    <a class="next">›</a>
	    <a class="close">×</a>
	    <a class="play-pause"></a>
	    <ol class="indicator"></ol>
	</div>
	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-upload fade">
	        <td>
	            <span class="preview"></span>
	        </td>
	        <td>
	            <p class="name">{%=file.name%}</p>
	            <strong class="error text-danger"></strong>
	        </td>
	        <td>
	            <p class="size">Processando...</p>
	            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
	        </td>
	        <td>
	            {% if (!i && !o.options.autoUpload) { %}
	                <button class="btn btn-primary start" disabled>
	                    <i class="glyphicon glyphicon-upload"></i>
	                    <span>Iniciar</span>
	                </button>
	            {% } %}
	            {% if (!i) { %}
	                <button class="btn btn-warning cancel" onClick="habilitaUpload()">
	                    <i class="glyphicon glyphicon-ban-circle"></i>
	                    <span>Cancelar</span>
	                </button>
	            {% } %}
	        </td>
	    </tr>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-download fade">
	        <td>
	            <span class="preview">
	                {% if (file.thumbnailUrl) { %}
	                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
	                {% } %}
	            </span>
	        </td>
	        <td>
	            <p class="name">
	                {% if (file.url) { %}
	                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
	                {% } else { %}
	                    <span>{%=file.name%}</span>
	                {% } %}
	            </p>
	            {% if (file.error) { %}
	                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
	            {% } %}
	        </td>
	        <td>
	            <span class="size">{%=o.formatFileSize(file.size)%}</span>
	        </td>
	        <td>
	            {% if (file.deleteUrl) { %}
	                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	                    <i class="glyphicon glyphicon-trash"></i>
	                    <span>Deletar</span>
	                </button>
	                <input type="checkbox" name="delete" value="1" class="toggle" onClick="habilitaUpload()">
	            {% } else { %}
	                <button class="btn btn-warning cancel" onClick="habilitaUpload()">
	                    <i class="glyphicon glyphicon-ban-circle"></i>
	                    <span>Cancelar</span>
	                </button>
	            {% } %}
	        </td>
	    </tr>
	{% } %}
	</script>
</div>
</div>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="../jquery-file-upload-9.5.7/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="../jquery-file-upload-9.5.7/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../jquery-file-upload-9.5.7/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../jquery-file-upload-9.5.7/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../jquery-file-upload-9.5.7/js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="../jquery-file-upload-9.5.7/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="../jquery-file-upload-9.5.7/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="../jquery-file-upload-9.5.7/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="jquery-file-upload-9.5.7/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->