<?php

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

// Checar se a postagem está sendo inserida ou alterada
$posId = (isset($_SESSION['posId'])) ? $_SESSION['posId'] : 0;
$postAction = ($posId > 0) ? 'updateuserpost' : 'insertuserpost';
$postHead = ($posId == 0) ? 'Nova postagem pessoal' : 'Editar postagem';

// Se for edição de postagem, carregar o texto do banco para edição...
// *** posteriormente
$o_post = array('posId' => 0,
                'posUser' => $o_user->user['usuId'],
                'posVisibility' => 1,
                'posText' => '');

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3><?php echo $postHead; ?></h3></header>
        <div class="w3-container">
            <p>
            <h3><?php echo $o_user->user['usuName']; ?></h3>
            <form method="post" class="w3-container" action="main.php?action=<?php echo $postAction; ?>">
                <label for="post">Postagem:</label><br>
                <textarea id="post" name="text" rows="10" cols="100">
                    <?php echo $o_post['posText']; ?>
                </textarea>
                <br><br>
                <p>Tipo de visibilidade:
                    <br>
                    <input type="radio" id="public" name="posVisibility" value="1" checked>
                    <label for="public">Pública</label>
                    <br>
                    <input type="radio" id="friends" name="posVisibility" value="2">
                    <label for="friends">Apenas amigos</label>
                    <br>
                    <input type="radio" id="particular" name="posVisibility" value="3">
                    <label for="particular">Particular</label>
                </p>
                <br>
                <input type="hidden" name="target" value="post">
                <input type="hidden" name="posUser" value="<?php echo $o_post['posUser']; ?>">
                <input type="hidden" name="posId" value="<?php echo $o_post['posId']; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=index">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>
