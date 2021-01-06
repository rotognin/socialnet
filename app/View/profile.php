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

// Carregar o usuário logado
$o_user = new Model\User($userId);

$message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Atualização de informações</h3></header>
        <div class="w3-container">
            <p>
            <h3><?php echo $o_user->user['usuName']; ?></h3>
            <form method="post" class="w3-container" action="main.php?action=updateuser">
                <label for="city">Cidade:</label>
                <input type="text" id="city" name="city" value="<?php echo $o_user->user['usuCity']; ?>">
                <br><br>
                <label for="state">Estado:</label>
                <input type="text" id="state" name="state" value="<?php echo $o_user->user['usuState']; ?>">
                <br><br>
                <input type="hidden" name="target" value="user">
                <input type="hidden" name="id" value="<?php echo $o_user->user['usuId']; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=index">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>

