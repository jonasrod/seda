<?php

function uploadFoto($file)
{

    //$image_x = 343;
    $image_y = 300;
    $thumb_y = 150;
    $trans_r = 255;
    $trans_g = 255;
    $trans_b = 255;
    $path_relativo = '/nytron/catalogo/';
    $path_completo = $_SERVER['DOCUMENT_ROOT'];
    $cache_uri = $path_completo . $path_relativo;

    $srid = time();

    $path_relativo .= $srid;

    $base_fs = $cache_uri . $srid;

    if (isset($file))
    {
        switch ($file['type'])
        {
            case 'image/jpeg':
            case 'image/pjpeg':
                $orig = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $orig = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $orig = imagecreatefromgif($file['tmp_name']);
                break;
            default:
                $error = 'Formato de arquivo inv&aacute;lido';
                $show = 'error';
        }

        if ($orig)
        {
            $orig_x = imagesx($orig);
            $orig_y = imagesy($orig);
            //$image_y = round(($orig_y * $image_x) / $orig_x);
            $image_x = round($orig_x * ($image_y / $orig_y));
            //$thumb_y = round(($orig_y * $thumb_x) / $orig_x);
            $thumb_x = round($orig_x * ($thumb_y / $orig_y));

            $image = imagecreatetruecolor($image_x, $image_y);
            imagecopyresampled($image, $orig, 0, 0, 0, 0, $image_x, $image_y, $orig_x, $orig_y);

            $thumb = imagecreatetruecolor($thumb_x, $thumb_y);
            imagecopyresampled($thumb, $orig, 0, 0, 0, 0, $thumb_x, $thumb_y, $orig_x, $orig_y);

            imagepng($image, $base_fs . '.jpg');
            imagepng($thumb, $base_fs . '-thumb.jpg');

            return $path_relativo;
        }
    }
}

function uploadLogo($file)
{

    //$image_x = 200;
    $image_y = 80;
    //$thumb_y = 118;
    $trans_r = 255;
    $trans_g = 255;
    $trans_b = 255;
    $path_relativo = '/parceiros/';
    $path_completo = $_SERVER['DOCUMENT_ROOT'];
    $cache_uri = $path_completo . $path_relativo;

    $srid = time();

    $path_relativo .= $srid;

    $base_fs = $cache_uri . $srid;

    if (isset($file))
    {
        switch ($file['type'])
        {
            case 'image/jpeg':
            case 'image/pjpeg':
                $orig = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/png':
                $orig = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/gif':
                $orig = imagecreatefromgif($file['tmp_name']);
                break;
            default:
                $error = 'Formato de arquivo inv&aacute;lido';
                $show = 'error';
        }

        if ($orig)
        {
            $orig_x = imagesx($orig);
            $orig_y = imagesy($orig);
            //$image_y = round(($orig_y * $image_x) / $orig_x);
            //$thumb_y = round(($orig_y * $thumb_x) / $orig_x);
            //$thumb_x = round($orig_x * ($thumb_y/$orig_y));
            $image_x = round($orig_x * ($image_y / $orig_y));

            $image = imagecreatetruecolor($orig_x, $image_y);
            imagecopyresampled($image, $orig, 0, 0, 0, 0, $orig_x, $image_y, $orig_x, $orig_y);

            //$thumb = imagecreatetruecolor($thumb_x, $thumb_y);
            //imagecopyresampled($thumb, $orig, 0, 0, 0, 0, $thumb_x, $thumb_y, $orig_x, $orig_y);

            imagepng($image, $base_fs . '.jpg');
            //imagepng($thumb, $base_fs . '-thumb.jpg');

            return $path_relativo . '.jpg';
        }
    }
}

function limpa($string)
{

    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);
    $string = str_replace('-', '', $string);
    $string = str_replace('.', '', $string);
    $string = str_replace('/', '', $string);
    $string = str_replace('\\', '', $string);
    $string = str_replace(',', '', $string);

    return $string;
}

function formataData($data)
{
    if (!empty($data))
    {
        return implode('/', array_reverse(explode('-', $data)));
    }
}

function formataDataHora($data)
{
    if (!empty($data))
    {
        $d = explode(' ', $data);
        return implode('/', array_reverse(explode('-', $d[0]))) . ' ' . $d[1];
    }
}

function formataDataBD($data)
{
    if (!empty($data))
    {
        return implode('-', array_reverse(explode('/', $data)));
    }
}

function formataMoeda($valor)
{
    return number_format($valor, 2, ',', '.');
}

function formataMoedaBD($valor)
{
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    return $valor;
}

function formataTel($tel)
{
    $retorno = '';
    if ($tel != 0 && !empty($tel))
    {
        $retorno = '(' . substr($tel, 0, 2) . ')' . substr($tel, 2, 4) . '-' . substr($tel, -4);
    }
    return $retorno;
}

function formataCep($cep)
{
    if (!empty($cep))
    {
        return substr($cep, 0, 5) . '-' . substr($cep, -3);
    }
}

function gerarSenha($length = 6)
{
    $array = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", 1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
    shuffle($array);
    $senha = array_slice($array, 0, $length);
    $senha = implode("", $senha);

    return $senha;
}

function email($from, $to, $assunto, $mensagem)
{
    $headers = "MIME-Version: 1.1\r\n";
    $headers = "Content-Type: text/html; charset=iso-8859-1" . "\n";
    $headers .= "Return-Path: Suporte <$from>\n";
    $headers .= "From: $from" . "\n";

    if (!mail($to, $assunto, $mensagem, $headers, "-r" . $from))
    { // Se for Postfix
        $headers .= "Return-Path: " . $from . "\n"; // Se "não for Postfix"
        mail($to, $assunto, $mensagem, $headers);
    }
}

function nomeMes($mes)
{
    $meses = array('Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    return $meses[$mes - 1];
}

?>