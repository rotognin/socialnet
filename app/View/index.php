<?php
/**
 * Página principal do usuário logado
 * Será tipo um "Dashboard" com as informações da pessoa, as atividades
 * de seus amigos e postagens feitas nas comunidades que ele participa
 */

use app\Model as Model;

$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

// Carregar o usuário logado
$o_user = new Model\User($userId);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <h3>Página principal</h3>
        <p><?php echo $o_user->user['usuId'] . ' - ' . $o_user->user['usuName']; ?></p>
        <p>Desde: <?php echo DateTime($o_user->user['usuDate']); ?></p>
        <br>
        <p>
        <a class="w3-button w3-blue" href="main.php?action=profile">Perfil</a>
        <a class="w3-button w3-blue" href="main.php?action=friends">Amigos</a>
        <a class="w3-button w3-blue" href="main.php?action=communities">Comunidades</a>
        <a class="w3-button w3-blue" href="main.php?action=logout">Sair</a>
        </p>
        <br>
    </div>
</body>
</html>