<?php

session_start();

include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/produto.class.php";
include_once "../model/subcategoria.class.php";
include_once "../model/produtocategoria.class.php";
include_once "../model/files.class.php";

$objBd = new BancodeDados();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'inserirProduto')
    {
    	//$objSubcategoria = new Subcategoria();
        //$objSubcategoria->obterSubcategoria( $_POST['subcategoriaid'] );
        
        $objMarca = new Marca();
        $objMarca->obterMarca( $_POST['marcaid'] );
        
        $flagLancamento = 0;
        $flagPromocao   = 0;
        $flagDestaque   = 0;
        
        if (isset($_POST['flPromocao'])) {
        	$flagPromocao = $_POST['flPromocao'];
        }
        
        if (isset($_POST['flLancamento'])) {
        	$flagLancamento = $_POST['flLancamento'];
        }
        
        if (isset($_POST['destaque'])) {
        	$flagDestaque = $_POST['destaque'];
        }
        
        if (isset($_POST['desconto'])) {
        	$_POST['desconto'] = str_replace('%', '', $_POST['desconto']);
        }
        
        $dados = array(
        	'produtoId'		   => $_POST['idProdutoInsert'],
        	//'mSubcategoriaId'  => $objSubcategoria->getSubcategoriaId(),
        	'mMarcaId' 		   => $objMarca->getMarcaId(),
        	'codigoProduto'    => $_POST['codigoProduto'],
        	'titulo' 	   	   => $_POST['titulo'],
            'descricao' 	   => $_POST['descricao'],
            'valor' 		   => Data::formataMoedaBD($_POST['valor']),
            'quantidade' 	   => $_POST['quantidade'],
            'quantidadeMinima' => $_POST['quantidadeMinima'],
            'peso' 			   => $_POST['peso'],
            'destaque' 		   => $flagDestaque,
            'informacao' 	   => nl2br(addslashes($_POST['informacao'])),
            'infotecnica' 	   => nl2br(addslashes($_POST['infotecnica'])),
            'desconto' 		   => ($_POST['desconto'] == '') ? 0 : $_POST['desconto'],
            'flPromocao' 	   => $flagPromocao,
            'flLancamento' 	   => $flagLancamento,
            'altura' 		   => $_POST['altura'],
            'largura' 		   => $_POST['largura'],
            'comprimento' 	   => $_POST['comprimento'],
            'tamanho' 	       => $_POST['tamanho']
        );
		
        if( !$objBd->insert( 'produto', $dados ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=produto-form&st=" . $msg . "'</script>";
            exit();
        }
        
        foreach($_POST['dadosCategoria'] as $categoriaSubcategoria) {
        	
        	$array_categoria = explode('|', $categoriaSubcategoria);
        	
        	$dados = array(
        		'mProdutoId' => $_POST['idProdutoInsert'],
        		'mCategoriaId' => $array_categoria[0],
        		'mSubcategoriaId' => $array_categoria[1]
        	);
        	
        	if( !$objBd->insert( 'produtocategoria', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='../view/index.php?p=produto-form&st=" . $msg . "'</script>";
	            exit();
	        }
        }
        
        //moveArquivoParaProdutos();
      
        $_SESSION['produto-form']['idProdutoInsert'] = 0; // para o caso do unset não zerar a sessao
        unset($_SESSION['produto-form']['idProdutoInsert']);
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=produto-lista&st=" . $msg . "'</script>";
        exit();
    }
    else if ( $_POST['action'] == 'editarProduto' )
    {
        $objProduto = new Produto();
        $objProduto->obterProduto( $_POST['idProduto'] );
        
        $flagLancamento = 0;
        $flagPromocao   = 0;
        $flagDestaque   = 0;
        
        if (isset($_POST['flPromocao'])) {
        	$flagPromocao = $_POST['flPromocao'];
        }
        
        if (isset($_POST['flLancamento'])) {
        	$flagLancamento = $_POST['flLancamento'];
        }
        
        if (isset($_POST['destaque'])) {
        	$flagDestaque = $_POST['destaque'];
        }
        
        if (isset($_POST['desconto'])) {
        	$_POST['desconto'] = str_replace('%', '', $_POST['desconto']);
        }
        
        $dados = array(
        	'mMarcaId' 		   => $_POST['marcaid'],
        	'codigoProduto'    => $_POST['codigoProduto'],
        	'titulo' 	   	   => $_POST['titulo'],
            'descricao' 	   => $_POST['descricao'],
            'valor' 		   => Data::formataMoedaBD($_POST['valor']),
            'quantidade' 	   => $_POST['quantidade'],
            'quantidadeMinima' => $_POST['quantidadeMinima'],
            'peso' 			   => $_POST['peso'],
            'destaque' 		   => $flagDestaque,
            'informacao' 	   => nl2br(addslashes($_POST['informacao'])),
            'infotecnica' 	   => nl2br(addslashes($_POST['infotecnica'])),
            'desconto' 		   => $_POST['desconto'],
            'flPromocao' 	   => $flagPromocao,
            'flLancamento' 	   => $flagLancamento,
            'altura' 		   => $_POST['altura'],
            'largura' 		   => $_POST['largura'],
            'comprimento' 	   => $_POST['comprimento'],
            'tamanho' 	       => $_POST['tamanho']
        );

        if( !$objBd->edit( 'produto', $dados, $objProduto->getProdutoId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=produto-forma&idProduto=".$objProduto->getProdutoId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        
        $sql = "delete from produtocategoria where mProdutoId = " . $objProduto->getProdutoId();
        $objBd->executarSQL($sql);
        
        
        foreach($_POST['dadosCategoria'] as $categoriaSubcategoria) {
        	
        	$array_categoria = explode('|', $categoriaSubcategoria);
        	
        	$dados = array(
        		'mProdutoId' => $_POST['idProdutoInsert'],
        		'mCategoriaId' => $array_categoria[0],
        		'mSubcategoriaId' => $array_categoria[1]
        	);
        	
        	if( !$objBd->insert( 'produtocategoria', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='../view/index.php?p=produto-form&st=" . $msg . "'</script>";
	            exit();
	        }
        }
        
       	//moveArquivoParaProdutos();
        
        $_SESSION['produto-form']['idProdutoInsert'] = 0; // para o caso do unset não zerar a sessao
        unset($_SESSION['produto-form']['idProdutoInsert']);
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=produto-lista&idProduto=".$objProduto->getProdutoId()."&st=" . $msg . "'</script>";
        exit();
    }
}
else if ( isset( $_GET['action'] ) )
{
    if ( $_GET['action'] == 'statusProduto' )
    {
        $idProduto = $_GET['idProduto'];
        
        $objProduto = new Produto();
        $objProduto->obterProduto( $_GET['idProduto'] );
        
        $dados = array(
            'status' => $_GET['status']
        );

        if( !$objBd->edit( 'produto', $dados, $objProduto->getProdutoId() ) )
        {
            $objBd->rollback();
            $msg = 'OPERACAO_ERRO';
            echo "<script>window.location='../view/index.php?p=produto-lista&idProduto=".$objProduto->getProdutoId()."&st=" . $msg . "'</script>";
            exit();
        }
        
        $objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        
        echo "<script>window.location='../view/index.php?p=produto-lista&idProduto=".$objProduto->getProdutoId()."&st=" . $msg . "'</script>";
        exit();
        
    } else if ($_GET['action'] == 'voltar') {
    	
		if ($_GET['type'] == 'inserirProduto') {
			/*
			$sql = "SELECT name " .
					" FROM files " .
					" WHERE mProdutoId = " . $_SESSION['produto-form']['idProdutoInsert'];
			$objFile = new Files();
			$result = $objBd->executarSQL($sql);
			
			foreach( $objFile->listarFileComFiltro( $result ) as $file ) {
				$file = $file->getName();
				
				if (unlink($_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/$file") === FALSE) {
					echo "falha ao remover arquivo";
					echo $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/$file";
					exit();
				}
				if ((unlink($_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/thumbnail/$file") === FALSE)) {
					echo "falha ao remover arquivo";
					echo $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/thumbnail/$file";
					exit();
				}
			}
			*/
		
			$sql = "DELETE FROM files WHERE mProdutoId = " . $_SESSION['produto-form']['idProdutoInsert'];
			$objBd->executarSQL($sql);
			
			$objBd->commit();
			
		} else if ($_GET['type'] == 'editarProduto') {
			
			//moveArquivoParaProdutos();
			
		}
		
		$_SESSION['produto-form']['idProdutoInsert'] = 0; // para o caso do unset não zerar a sessao
        unset($_SESSION['produto-form']['idProdutoInsert']);
		
    	echo "<script>window.location='../view/index.php?p=produto-lista';</script>";
        exit();
        
    } else if ($_GET['action'] == 'editar') { // antes de ir para o form de edicao passa pelo controller para mover as fotos para o fileupload
    	/*
    	$sql = "SELECT name " .
				" FROM files " .
				" WHERE mProdutoId = " . $_GET['idProduto'];
		$objFile = new Files();
		$result = $objBd->executarSQL($sql);
		
		$imagens = array();
		foreach( $objFile->listarFileComFiltro( $result ) as $file ) {
			$imagens[] = $file->getName();
		}
		
		$dest_path 	     = $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/";
		$dest_path_thumb = $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/thumbnail/";
		
		$source_path 	   = $_SERVER['DOCUMENT_ROOT'] . "/produtos/fotos/";
		$source_path_thumb = $_SERVER['DOCUMENT_ROOT'] . "/produtos/fotos/thumbnail/";
		
		if ($handle = opendir($source_path)) {
			
			while (false !== ($file = readdir($handle))) {
				if($file == ".." || $file == ".") continue;
		        
		        if ($file == "thumbnail") continue;
		        
		        if (in_array($file, $imagens)) {
		        	if (!rename($source_path.$file, $dest_path.$file)) {
						echo "Origem: $source_path$file<br>";
						echo "Destino: $dest_path$file<br>";
						echo "Erro ao mover arquivo.<br>";
						exit();
					}
		        }
		    }
		    
		    closedir($handle);
		} 
		
		if ($handle = opendir($source_path_thumb)) {
			
			while (false !== ($file = readdir($handle))) {
				
				if($file == ".." || $file == ".") continue;
				
				if (in_array($file, $imagens)) {
					if (!rename($source_path_thumb.$file, $dest_path_thumb.$file)) {
						echo "Origem: $source_path_thumb$file<br>";
						echo "Destino: $dest_path_thumb$file<br>";
						echo "Erro ao mover thumb.";
						exit();
					}
				}
			}
			
			closedir($handle);
		}
    	*/
    	echo "<script>window.location='../view/index.php?p=produto-form&idProduto=".$_GET['idProduto']."';</script>";
        exit();
    	
    }
}

function moveArquivoParaProdutos() {
	/**
     * INICIO
     * Rotina para movimentacao das imagens para o diretorio correto
     */
    $source_path 	   = $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/";
	$source_path_thumb = $_SERVER['DOCUMENT_ROOT'] . "/wcm/view/server/php/files/thumbnail/";
	
	$dest_path 		 = $_SERVER['DOCUMENT_ROOT'] . "/produtos/fotos/";
	$dest_path_thumb = $_SERVER['DOCUMENT_ROOT'] . "/produtos/fotos/thumbnail/";
	
	if ($handle = opendir($source_path)) {
		
		while (false !== ($file = readdir($handle))) {
			if($file == ".." || $file == ".") continue;
	        
	        if ($file == "thumbnail") continue;
	        
			if (!rename($source_path.$file, $dest_path.$file)) {
				echo "Origem: $source_path$file<br>";
				echo "Destino: $dest_path$file<br>";
				echo "Erro ao mover arquivo.<br>";
				exit();
			}
	    }
	    
	    closedir($handle);
	} 
	
	if ($handle = opendir($source_path_thumb)) {
		
		while (false !== ($file = readdir($handle))) {
			
			if($file == ".." || $file == ".") continue;
			
			if (!rename($source_path_thumb.$file, $dest_path_thumb.$file)) {
				echo "Origem: $source_path_thumb$file<br>";
				echo "Destino: $dest_path_thumb$file<br>";
				echo "Erro ao mover thumb.";
				exit();
			}
		}
		
		closedir($handle);
	}
     /**
      * FIM 
      */
}
?>