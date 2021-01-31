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
        <h3><?php echo $o_user->user['usuId'] . ' - ' . $o_user->user['usuName']; ?></h3>
        <p>Desde: <?php echo DateTime($o_user->user['usuDate']); ?></p>
        <br>
        <p>
        <a class="w3-button w3-blue" href="main.php?action=profile">Perfil</a>
        <a class="w3-button w3-blue" href="main.php?action=listfriends&usertarget=<?php echo $o_user->user['usuId']; ?>">Amigos</a>
        <a class="w3-button w3-blue" href="main.php?action=listcommunities">Comunidades</a>
        <a class="w3-button w3-blue" href="main.php?action=logout">Sair</a>
        </p>
        <br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <h3>Postagens:</h3>
        <p>
        <a class="w3-button w3-blue" href="main.php?action=createuserpost">Criar</a>
        <a class="w3-button w3-blue" href="main.php?action=listuserposts">Listar</a>
        </p>
        <br>
    </div>
    <div class="w3-container w3-card-4 w3-margin">
        <h3>Mensagens para você:</h3>
        <p>
        <a class="w3-button w3-blue" href="main.php?action=listusermessages">Listar Todas</a>
            <!-- Exibir as mensagens não lidas dos amigos para o usuário -->
        </p>
        <br>
    </div>
</body>
</html>