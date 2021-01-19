<?php

/**
 * Tela da comunidade exibida
 */
use app\Model as Model;

// Usuário logado
$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}



?>

