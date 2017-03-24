<?php

include_once '../model/alerta.class.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <title>System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nepali">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="../css/bootstrap-responsive.min.css" rel="stylesheet">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->
    
    <script>
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#formLogin").validate({
				errorContainer: container,
				errorLabelContainer: $("ol", container),
				wrapper: 'li'
			});
		});
	</script>
  </head>
  <body>
    <div class="container">
	  <div class="control-group" id="container">
	  	<div class="alert alert-error" style="display: none;">
	  		<ol>
	  			<li>Preencha corretamento os campos do formul&aacute;rio!</li>
	  		</ol>
	  	</div>
	  	
	  </div>
      <form action="../controller/login-controle.php" class="form-signin" method="post" id="formLogin">
      <input type="hidden" name="action" value="autenticarUsuario">
        <p>&nbsp;</p>
        <p>
		<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
		</p>
        <input type="text" name="login" class="input-block-level" placeholder="Usuário" required>
        <input type="password" name="senha" class="input-block-level" placeholder="Senha" required>
        <button class="btn btn-large btn-success" type="submit">Entrar</button>
      </form>
    </div> <!-- /container -->
  </body>
</html>