<?php

/**
 * Perfil do usuário logado.
 */
use app\Model as Model;

$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

$o_post = new Model\Post();
$userposts = $o_post->listAll($userId, 'DESC');

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Postagens:</h3></header>
        <?php 
            foreach($userposts as $post){
                $html  = '';
                $html  = '<div class="w3-container w3-card-4 w3-margin w3-padding">';
                $html .= '<a class="w3-button w3-red w3-right" href="main.php?action=deleteuserpost">Apagar</a>';
                $html .= '<a class="w3-button w3-blue w3-right w3-margin-right" href="main.php?action=edituserpost">Editar</a>';
                $html .= 'ID: ' . $post['posId'] . ' - Data: ' . DateTime($post['posDate']) . ' - ';
                $html .= 'Visibilidade: ' . $o_post->visibilityDescription($post['posVisibility']);
                $html .= '<br><p>' . nl2br($post['posText']) . '</p></div>';
                echo $html;
            }
        ?>
        <p><a href="socialnet.php?view=index">Voltar</a></p>
    </div>
</body>
</html>