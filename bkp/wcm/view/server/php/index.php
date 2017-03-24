<?php
header('Content-Type: text/html; charset=UTF-8');
@session_start();
$options = array(
    'delete_type' => 'POST',
    'db_host'     => 'localhost',
    'db_user'     => 'sedaerot_seda',
    'db_pass'     => '3r0t1c4',
    'db_name'     => 'sedaerot_loja',
    'db_table'    => 'files',
    'mProdutoId'  => $_SESSION['produto-form']['idProdutoInsert'],
    'upload_dir'  => $_SERVER['DOCUMENT_ROOT'] . "/produtos/fotos/" . $_SESSION['produto-form']['idProdutoInsert'] . '/',
    'upload_url'  => 'http://www.sedaerotica.com.br/produtos/fotos/' . $_SESSION['produto-form']['idProdutoInsert'] . '/'
);

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        $this->db = new mysqli(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );
        $this->db->set_charset('utf8');
        parent::initialize();
        $this->db->close();
    }

    protected function handle_form_data($file, $index) {
        $file->title = @$_REQUEST['title'][$index];
        $file->description = @$_REQUEST['description'][$index];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
        	$this->db->set_charset('utf8');
            $sql = 'INSERT INTO `'.$this->options['db_table']
                .'` (`name`, `size`, `type`, `title`, `description`, `mProdutoId`)'
                .' VALUES (?, ?, ?, ?, ?, '.$this->options['mProdutoId'].')';
            $query = $this->db->prepare($sql);
            $query->bind_param(
                'sisss',
                $file->name,
                $file->size,
                $file->type,
                $file->title,
                $file->description
            );
            $query->execute();
            $file->id = $this->db->insert_id;
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `id`, `type`, `title`, `description` FROM `'
                .$this->options['db_table'].'` WHERE `name`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type,
                $title,
                $description
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
                $file->title = $title;
                $file->description = $description;
            }
        }
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    .$this->options['db_table'].'` WHERE `name`=?';
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
            }
        } 
        return $this->generate_response($response, $print_response);
    }

}

$upload_handler = new CustomUploadHandler($options);
?>
