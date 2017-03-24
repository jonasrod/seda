<?php

ob_start();

function paginaRestrita()
{
    if (isset($_SESSION['wcm']['brw_logado']))
    {
        if ($_SESSION['wcm']['brw_logado'] == false)
        {
            echo "<script>window.location='../view/index.php'</script>";
            exit;
        }
    }
    else
    {
        echo "<script>window.location='../view/login.php'</script>";
        exit;
    }
}

ob_end_flush();

?>