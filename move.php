<?php
include_once "wcm/config.php";
include_once "wcm/model/bancodedados.class.php";
include_once "wcm/model/data.class.php";
include_once "wcm/model/produto.class.php";
include_once "wcm/model/subcategoria.class.php";
include_once "wcm/model/produtocategoria.class.php";
include_once "wcm/model/files.class.php";

$objBd = new BancodeDados();
$objProduto = new Produto();

$source_path = $_SERVER['DOCUMENT_ROOT'] . "/tmpimg/";
//$source_path = "h:/workspace/sedaerotica/tmpimg/";

$sem_imagem = array();

foreach($objProduto->listarProduto() as $produto) {
	
	        
    $dest_path = $_SERVER['DOCUMENT_ROOT'] . '/produtos/fotos/'.$produto->getProdutoId() . '/';
    
    $i = 1;
    
    do {
    	
    	if ($i == 1) {
    		$imagem = strtoupper(trim($produto->getCodigoProduto())) . '.jpg';
    	}
    	
    	if (file_exists($source_path.$imagem) && !file_exists($dest_path.$imagem)) {
        	
        	if (!rename($source_path.$imagem, $dest_path.$imagem)) {
				echo "Origem: $source_path$imagem<br>";
				echo "Destino: $dest_path$imagem<br>";
				echo "Erro ao mover arquivo.<br>";
				exit();
			}
			
			echo $dest_path.$imagem . '<br />';
			
			$dados = array(
	            'name' 		 => $imagem,
	            'size' 		 => filesize($dest_path.$imagem),
	            'type' 		 => 'image/jpeg',
	            'mProdutoId' => $produto->getProdutoId()
	        );
			
	        if( !$objBd->insert( 'files', $dados ) )
	        {
	            $objBd->rollback();
	            exit();
	        }
        } else {
        	if (!file_exists($dest_path.$imagem)) {
        		$sem_imagem[] = $produto->getCodigoProduto();
        	}
        }
    	
    	$i++;
    	$imagem = $produto->getCodigoProduto() . "_$i.jpg";
    } while (file_exists($source_path.$imagem));
    
    $objBd->commit();
}

print_rr($sem_imagem);
?>