<?php

include_once '../config.php';
include_once 'bd.class.php';

class Gerador
{
    private $bd;
    private $pathRoot;
    
    public function __construct()
    {
        $this->bd = new BancodeDados();
        
        $this->pathRoot = 'classesGeradas';
        
        if( !is_dir( $this->pathRoot ) )
            mkdir( $this->pathRoot, 0777);
        
        $sql = 'show tables from ' . DB_NAME;
        $result = $this->bd->executarSQL($sql);
        
        $this->createModel( $result );
        mysql_data_seek( $result, 0 );
        $this->createAdmin( $result );
    }
    
    private function createFile( $path, $fileName, $content )
    {
        if( !is_dir( $path ) )
            mkdir( $path, 0777);
        
        $fp = fopen( $path.$fileName, 'w' );
        $fw = fwrite( $fp, $content );
        fclose( $fp );

        echo '>> ' . $path . $fileName . '<br/>';
    }
    
    private function createAdmin( $result )
    {
        while ( $rowTabela = mysql_fetch_array( $result ) )
        {
            $tableName = $rowTabela[0];

            $sqlField = 'select * from ' . $tableName;
            $resField = $this->bd->executarSQL( $sqlField );
            $numFields = mysql_num_fields( $resField );

            // --------------
            $path = $this->pathRoot . '/admin/';
            $fileName = $tableName . '-form.php';
            // --------------
            
            $formHTML  = '<?php' . "\n\n";
            
            $formHTML .= "include_once '../model/" . strtolower( $tableName ) . ".class.php';\n";
            
            // Includa as classes de chaves estrangeiras
            // ----------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $formHTML .= "include_once '../model/" . strtolower(substr(mysql_field_name($resField, $i), 1)) . ".class.php';\n";
                }
            }
            
            // Instancia as classes de chaves estrangeiras
            // ----------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 1));

                    $formHTML .= "\n" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '();';
                }
            }
            
            $formHTML .= "\n" . '$obj' . ucfirst( $tableName ) . ' = new ' . ucfirst( $tableName ) . '();';
            
            $formHTML .= "\n\n" . '$action = "inserir'.ucfirst( $tableName ).'";';

            $formHTML .= "\n\n" . 'if( isset( $_GET["id'. ucfirst( $tableName ) .'"] ) )';
            $formHTML .= "\n" . '{';
            $formHTML .= "\n\t" . '$action = "editar'. ucfirst( $tableName ) .'";';
            $formHTML .= "\n\t" . '$obj'. ucfirst( $tableName ) .'->obter'. ucfirst( $tableName ) .'( $_GET["id'. ucfirst( $tableName ) .'"] );';
            $formHTML .= "\n" . '}';
            $formHTML .= "\n\n" . '?>';
            $formHTML .= "\n\n" . '<script src="../js/jquery.validate.min.js"></script>';
            //$formHTML .= "\n" . '<script src="../js/maskedinput-1.3.min.js"></script>';
            
            $formHTML .= "\n\n" . '<div class="span6">'."\n".'<div class="row-fluid">';
            $formHTML .= "\n" . '<form id="form1" name="form1" method="post" action="../controller/'. strtolower( $tableName ) .'-controle.php"  class="form-inline">';
            $formHTML .= "\n\n" . '<p><a href="index.php?cmd='. $tableName .'-lista" class="btn btn-info">&lt;&lt; Voltar</a>';
            $formHTML .= "\n" . '<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" /></p>';
            $formHTML .= "\n\n" . '<input type="hidden" name="action" value="<?=$action?>" />';
            $formHTML .= "\n" . '<input type="hidden" name="id'. ucfirst( $tableName ) .'" value="<?=$obj'. ucfirst( $tableName ) .'->get'. ucfirst( $tableName ) .'ID()?>" />';
            
            // Inicia os atributos vazios
            // --------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $nome = mysql_field_name($resField, $i);

                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 1));
                    
                    $formHTML .= "\n\n" . '<div class="control-group">';
                    $formHTML .= "\n\t" . '<label for="'. strtolower(substr($nome, 1)) .'" class="control-label span3">'. $nomeTemp .'</label>';
                    $formHTML .= "\n\t" . '<select name="'. strtolower(substr($nome, 1)) .'" id="'. strtolower(substr($nome, 1)) .'" class="span9" required="true">';
                    $formHTML .= "\n\t" . '<option value="" disabled="disabled" selected="selected">Selecione a '. strtolower(substr($nome, 1)) .'</option>';
                    $formHTML .= "\n\t" . '<?php foreach( $obj'.substr($nome, 1).'->listar'.ucfirst(substr($nome, 1)).'() as $'. strtolower(substr($nome, 1)) .' ) { ?>';
                    $formHTML .= "\n\t\t" . '<option value="<?=$'. strtolower(substr($nome, 1)) .'->get'.substr($nome, 1).'ID()?>" <?php if( $'. strtolower(substr($nome, 1)) .'->get'.substr($nome, 1).'ID() == $obj'.ucfirst( $tableName ).'->get'.$nomeTemp.'()->get'. substr($nome, 1) .'ID() ){ ?>selected="selected"<?php } ?>>';
                    $formHTML .= "\n\t\t" . '<?=$'. strtolower(substr($nome, 1)) .'->getDescricao()?></option>';
                    $formHTML .= "\n\t" . '<?php } ?>';
                    $formHTML .= "\n\t" . '</select>';
                    $formHTML .= "\n" . '</div>';
                }
                else
                {
                    $formHTML .= "\n\n" . '<div class="control-group">';
                    $formHTML .= "\n\t" . '<label class="control-label span3" for="'. $nome .'">'. ucfirst( $nome ) .'</label> ';
                    $formHTML .= "\n\t" . '<input type="text" name="'. $nome .'" id="'. $nome .'"  class="span9" required="true" value="<?=$obj'. ucfirst( $tableName ) .'->get'. ucfirst( $nome ) .'()?>" />';
                    $formHTML .= "\n" . '</div>';
                }
            }
            
            $formHTML .= "\n\n" . '</form>'."\n</div>\n</div>";

            $this->createFile( $path, $fileName, $formHTML );
            
        }
    }
    
    private function createController()
    {
        
    }
    
    private function createModel( $result )
    {
        while ($rowTabela = mysql_fetch_array($result))
        {
            $nomeClasse = $rowTabela[0];

            $sqlField = 'select * from ' . $nomeClasse;
            $resField = $this->bd->executarSQL($sqlField);
            $numFields = mysql_num_fields($resField);

            // Configura o diretorio e o nome do arquivo
            // --------------------
            $path = $this->pathRoot . '/model/';
            $fileName = $nomeClasse . '.class.php';
            
            $string = "<?php \n\n";
            
            $string .= 'include_once "bancodedados.class.php";';
            $string .= "\n\n";
            
            // Includa as classes de chaves estrangeiras
            // ----------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $string .= "include_once '" . strtolower(substr(mysql_field_name($resField, $i), 1)) . ".class.php';\n";
                }
            }

            $string .= "\nclass " . ucfirst($nomeClasse) . "\n{\n";
            $string .= "\tprivate " . '$bd;' . "\n";
            
            // Criar os atributos da classe
            // -----------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    // Se for chave estrangeira, retiramos o 'm' do inicio do nome do campo
                    $string .= "\tprivate $" . strtolower(substr(mysql_field_name($resField, $i), 1)) . ";\n";
                } else
                {
                    $string .= "\tprivate $" . mysql_field_name($resField, $i) . ";\n";
                }
            }

            $string .= "\n\tpublic function __construct()\n\t{\n\t\t";
            $string .= '$this->bd = BancodeDados::getInstance();' . "\n";
            
            // Inicia os atributos vazios
            // --------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $nome = mysql_field_name($resField, $i);

                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 1));

                    $string .= "\n\n\t\t" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '();';
                    $string .= "\n\t\t" . '$this->' . strtolower(substr($nome, 1)) . ' = $obj' . $nomeTemp . ';';
                } 
                else
                {
                    $string .= "\n\t\t" . '$this->' . $nome . " = '';";
                }
            }
            
            $string .=  "\n\t}\n\n";
            
            // Monta os metodos set's
            // -----------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $nome = mysql_field_name($resField, $i);

                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $string .= "\tpublic function set" . ucfirst(substr($nome, 1)) . '( $' . strtolower(substr($nome, 1)) . ' )' . "\n\t{\n\t";
                    $string .= "\t" . '$this->' . strtolower(substr($nome, 1)) . ' = ' . '$' . strtolower(substr($nome, 1)) . ";\n\t}\n\n";
                }
                else
                {
                    $string .= "\tpublic function set" . ucfirst($nome) . '( $' . $nome . ' )' . "\n\t{\n\t";
                    $string .= "\t" . '$this->' . $nome . ' = ' . '$' . $nome . ";\n\t}\n\n";
                }
            }
            
            // Monta os metodos get's
            // ------------------
            for ($i = 0; $i < $numFields; $i++)
            {
                $nome = mysql_field_name($resField, $i);

                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $string .= "\tpublic function get" . ucfirst(substr($nome, 1)) . '()' . "\n\t{\n\t";
                    $string .= "\treturn " . '$this->' . strtolower(substr($nome, 1)) . ";\n\t}\n\n";
                } else
                {
                    $string .= "\tpublic function get" . ucfirst($nome) . '()' . "\n\t{\n\t";
                    $string .= "\treturn " . '$this->' . $nome . ";\n\t}\n\n";
                }
            }
            
            // Metodo obterEntidade
            // ---------------
            $string .= "\tpublic function obter" . ucfirst($nomeClasse) . "( $" . $nomeClasse . "ID )\n\t{\n\t\t";
            $string .= '$result = $this->bd->obterRegistroPorId( "' . $nomeClasse . '", $' . $nomeClasse . 'ID );' . "\n";
            $string .= "\t\t" . 'return $this->montarObjeto( $result->fetch_array() );' . "\n\t}";
            
            // Metodo listarEntidade
            // ---------------
            $string .= "\n\n\t";
            $string .= 'public function listar' . ucfirst($nomeClasse) . '( Paginacao $objPaginacao = NULL )' . "\n\t{\n\t\t";
            $string .= '$sql  = "select * ";' . "\n\t\t";
            $string .= '$sql .= "from '. $nomeClasse .' ";' . "\n\n\t\t";
            $string .= 'if ($objPaginacao)' . "\n\t\t{\n\t\t\t";
            $string .= '$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();' . "\n\t\t}";
            $string .= "\n\n\t\t" . '$result = $this->bd->executarSQL($sql);';
            $string .= "\n\n\t\t" . 'if ( $result->num_rows > 0 )';
            $string .= "\n\t\t\t" . 'return $this->montarLista($result);';
            $string .= "\n\t\t" . 'else';
            $string .= "\n\t\t\t" . 'return array();' . "\n\t}";
            
            // Metodo montarLista
            // ---------------
            $string .= "\n\n\t" . 'private function montarLista( $result )' . "\n\t{";
            $string .= "\n\t\t" . 'if( $result->num_rows > 0 )' . "\n\t\t{";
            $string .= "\n\t\t\t" . 'while( $row = $result->fetch_array() )' . "\n\t\t\t{";
            $string .= "\n\t\t\t\t" . '$obj = new self();';
            $string .= "\n\t\t\t\t" . '$obj->montarObjeto( $row );';
            $string .= "\n\t\t\t\t" . '$objs[] = $obj;';
            $string .= "\n\t\t\t\t" . '$obj = null;' . "\n\t\t\t}";
            $string .= "\n\t\t\t" . 'return $objs;' . "\n\t\t}";
            $string .= "\n\t\telse\n\t\t{";
            $string .= "\n\t\t\treturn false;\n\t\t}\n\t}";


            // M�todo montarObjeto
            // ---------------
            $string .= "\n\n\t" . 'private function montarObjeto( $row )' . "\n\t{";

            for ($i = 0; $i < $numFields; $i++)
            {
                $nome = mysql_field_name($resField, $i);

                $flags = explode(' ', mysql_field_flags($resField, $i));

                if (in_array('multiple_key', $flags))
                {
                    $nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 1));

                    $string .= "\n\n\t\t" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '();';
                    $string .= "\n\t\t" . '$obj' . $nomeTemp . '->obter' . $nomeTemp . '( $row["m' . $nomeTemp . '"] );' . "\n";

                    $string .= "\n\t\t" . '$this->set' . ucfirst(substr($nome, 1)) . '( ' . '$obj' . $nomeTemp . ' );';
                } else
                {
                    $string .= "\n\t\t" . '$this->set' . ucfirst($nome) . '( $row["' . $nome . '"] );';
                }
            }

            $string .= "\n\t}";

            $string .= "\n}\n?>";
            
            
            
            $this->createFile( $path, $fileName, $string );
            
        }
    }
}

new Gerador();
