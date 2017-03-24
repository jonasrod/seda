<?php

include_once '../model/produto.class.php';
include_once '../model/marca.class.php';
include_once '../model/categoria.class.php';
include_once '../model/subcategoria.class.php';
include_once '../model/produtosequence.class.php';
include_once '../model/data.class.php';
include_once '../model/alerta.class.php';

$objData = new Data();

?>

<script type="text/javascript" src="../js/jquery.validate.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
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

</script>

<div class="span6">
<div class="row-fluid">
	<p><a href="index.php" class="btn btn-info">&lt;&lt; Voltar</a>
	<form id="fileupload" action="server/banner_lateral/index.php" method="POST" enctype="multipart/form-data">
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
<script src="../jquery-file-upload-9.5.7/js/banner_lateral.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="jquery-file-upload-9.5.7/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->