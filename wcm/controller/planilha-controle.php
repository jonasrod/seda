<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();  

include_once "../excel-reader/excel_reader2.php";
include_once "../config.php";
include_once "../model/bancodedados.class.php";
include_once "../model/data.class.php";
include_once "../model/produto.class.php";
include_once "../model/subcategoria.class.php";
include_once "../model/produtocategoria.class.php";
include_once "../model/produtosequence.class.php";
include_once "../model/categoria.class.php";
include_once "../model/subcategoria.class.php";

//require_once '../Classes/PHPExcel/IOFactory.php';

$objBd = new BancodeDados();
$objSequence = new Produtosequence();

if (isset($_POST['action']))
{
    if ($_POST['action'] == 'inserirPlanilha')
    {
    	$uploadfile = '';
		$data = '';
		
    	$uploaddir = PLANILHA_PATH;
		$uploadfile = $uploaddir . $_FILES['planilha']['name'];
		if (!move_uploaded_file($_FILES['planilha']['tmp_name'], $uploaddir . $_FILES['planilha']['name'])) {
		    $msg = 'ERRO_UP_PLANILHA';
            echo "<script>window.location='../view/index.php?p=planilha-form&st=" . $msg . "'</script>";
            exit();
		}
		
		$data = new Spreadsheet_Excel_Reader($uploadfile);

		for( $i=2; $i <= $data->rowcount($sheet_index=0); $i++ ) {
			$cod_seda 	  = $data->val($i, 1);
			$cod_original = $data->val($i, 2);
			$marca 		  = $data->val($i, 3);
			$nome_produto = $data->val($i, 4);
			$descricao    = $data->val($i, 5);
			$info_produto = $data->val($i, 6);
			$info_tecnica = $data->val($i, 7);
			$cor 		  = $data->val($i, 8);
			$tamanho 	  = $data->val($i, 9);
			$peso 		  = $data->val($i, 10);
			$altura 	  = $data->val($i, 11);
			$largura	  = $data->val($i, 12);
			$comprimento  = $data->val($i, 13);
			$valor		  = $data->val($i, 14);
			$disponivel   = $data->val($i, 15);
			$disp_estoque = $data->val($i, 16);
			$quantidade   = $data->val($i, 17);
			$qtde_aviso   = $data->val($i, 18);
			$destaque     = $data->val($i, 19);
			$qtde_parcela = $data->val($i, 20);
			$taxa_parcela = $data->val($i, 21);
			$desconto 	  = $data->val($i, 22);
			$categoria 	  = $data->val($i, 23);
			$subcategoria = $data->val($i, 24);
			
			$objMarca = new Marca();
        	$objMarca->obterMarcaPorNome( strtolower($marca) );
        	
        	$marcaId = 0;
        	
        	if ($objMarca->getDescricao() == '') {
				$dados = array(
		            'descricao' => $objMarca->getDescricao()
		        );
				
		        if( !$marcaId = $objBd->insert( 'marca', $dados ) )
		        {
		            $objBd->rollback();
		            $msg = 'OPERACAO_ERRO';
		            echo "<script>window.location='../view/index.php?p=planilha-form&st=" . $msg . "'</script>";
		            exit();
		        }
        	} else {
        		$marcaId = $objMarca->getMarcaId();
        	}
			
			$flagDestaque = 0;
			
			if (trim($destaque) != '' && trim(strtolower($destaque)) == 'sim')
			{
				$flagDestaque = 1;
			} 
			
			$produtoId = $objSequence->getLastID();
			
			$dados = array(
	        	'produtoId'		   => $produtoId,
	        	'mMarcaId' 		   => $marcaId,
	        	'codigoProduto'    => $cod_seda,
	        	'titulo' 	   	   => $nome_produto,
	            'descricao' 	   => $descricao,
	            'valor' 		   => Data::formataMoedaBD($valor),
	            'quantidade' 	   => $quantidade,
	            'quantidadeMinima' => $qtde_aviso,
	            'peso' 			   => $peso,
	            'destaque' 		   => $flagDestaque,
	            'informacao' 	   => nl2br($info_produto),
	            'infotecnica'	   => nl2br($info_tecnica),
	            'desconto' 		   => (trim($desconto) == '') ? 0 : Data::formataMoedaBD($desconto),
	            //'flPromocao' 	   => $flagPromocao,
	            //'flLancamento'   => $flagLancamento,
	            'altura' 		   => $altura,
	            'largura' 		   => $largura,
	            'comprimento' 	   => $comprimento,
	            'tamanho' 	       => $tamanho
	        );
			
	        if( !$objBd->insert( 'produto', $dados ) )
	        {
	            $objBd->rollback();
	            $msg = 'OPERACAO_ERRO';
	            echo "<script>window.location='../view/index.php?p=produto-form&st=" . $msg . "'</script>";
	            exit();
	        }
	        
	        $objCategoria = new Categoria();
	        $objSubcategoria = new Subcategoria();
	        
	        //$categorias    = explode('/', $categoria);
	        $subcategorias = explode(' / ', $subcategoria);
	        
	        if (count($subcategorias) > 1) {
	        	for($j = 0; $j < count($subcategorias); $j++) {
	        		//$objCategoria->obterCategoriaPorNome(trim($categorias[$j]));
	        		$objSubcategoria->obterSubcategoriaPorNome(trim($subcategorias[$j]));
	        		
		        	$dados = array(
		        		'mProdutoId'      => $produtoId,
		        		'mCategoriaId'    => $objSubcategoria->getCategoriaId()->getCategoriaId(),
		        		'mSubcategoriaId' => $objSubcategoria->getSubcategoriaId()
		        	);
		        	
		        	if( !$objBd->insert( 'produtocategoria', $dados ) )
			        {
			            $objBd->rollback();
			            $msg = 'OPERACAO_ERRO';
			            echo "<script>window.location='../view/index.php?p=planilha-form&st=" . $msg . "'</script>";
			            exit();
			        }
	        	}
	        } else {
	        	$objSubcategoria->obterSubcategoriaPorNome(trim($subcategoria));
	        		
	        	$dados = array(
	        		'mProdutoId'      => $produtoId,
	        		'mCategoriaId'    => $objSubcategoria->getCategoriaId()->getCategoriaId(),
	        		'mSubcategoriaId' => $objSubcategoria->getSubcategoriaId()
	        	);
	        	
	        	if( !$objBd->insert( 'produtocategoria', $dados ) )
		        {
		            $objBd->rollback();
		            $msg = 'OPERACAO_ERRO';
		            echo "<script>window.location='../view/index.php?p=planilha-form&st=" . $msg . "'</script>";
		            exit();
		        }
	        }
		}
		
		$objBd->commit();
        $msg = 'OPERACAO_SUCESSO';
        echo "<script>window.location='../view/index.php?p=produto-lista&st=" . $msg . "'</script>";
        exit();
    }
}
?>
