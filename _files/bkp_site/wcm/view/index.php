<?php
session_start();	
include_once '../config.php';
include_once '../controller/verifica-login.php';
include_once '../controller/ajax-controle.php';

paginaRestrita();

isset($_GET['p']) ? $pagina = $_GET['p'] : $pagina = "home";
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include_once("default_head.inc.php");?>
    <?php  
	 /*** print the javasript ***/  
	 $xajax->printJavascript();  
	?>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
			//
			
		});
		
		function getSubcategoria() {
			xajax_getSubcategoria($("#categoria").val());
		}
	</script>
	<?php
	if ($pagina == 'produto-form') {
		?>
		<link rel="stylesheet" href="../jquery-file-upload-9.5.7/css/style.css">
		<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
		<link rel="stylesheet" href="../jquery-file-upload-9.5.7/css/jquery.fileupload.css">
		<link rel="stylesheet" href="../jquery-file-upload-9.5.7/css/jquery.fileupload-ui.css">
		<style type="text/css">
			.disableUpload {
				display: none;
			}
			.enableUpload {
				display: block;
			}
		</style>
		<?php
	}
	?>
	<style rel="stylesheet" type="text/css" media="print">
   		.noPrint{display:none}
	</style>
  </head>
  <body>
    <?php include_once("header.inc.php");?>
    <div class="page" id="divPage">
      <div class="page-container">
		<div class="container">
		  <div class="row">
          	
		    	<?php include_once("$pagina.php"); ?>
            
		  </div>
		</div>
      </div>
    </div>
    <?php include_once("footer.inc.php");?>
  </body>
</html>