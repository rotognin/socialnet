<?php

session_start();
require 'lib' . DIRECTORY_SEPARATOR . 'definitions.php';
require 'lib' . DIRECTORY_SEPARATOR . 'formatting.php';

// Carrega o caminho da View correspondente
$view = DIR['view'] . $_GET['view'] . '.php';
$userId = (isset($_SESSION['userId'])) ? (integer) $_SESSION['userId'] : (integer) 0;

if ($userId == 0){
    $_SESSION['message'] = 'Acesso não autorizado. Realize o login.';
    header('Location: index.php');
    exit();
}

// Carregar a View e exibir seu conteúdo
ob_start();
require_once $view;
$html = ob_get_contents();
ob_end_clean();
echo $html;