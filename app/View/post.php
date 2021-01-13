<?php

use app\Model as Model;
use app\Controller as Controller;

$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

// Carregar o usuário logado
$o_user = new Model\User($userId);

// Checar se a postagem está sendo inserida ou alterada
$posId = (isset($_GET['posId'])) ? $_GET['posId'] : 0;
$postAction = ($posId > 0) ? 'updateuserpost' : 'insertuserpost';
$postHead = ($posId == 0) ? 'Nova postagem pessoal' : 'Editar postagem';

// Se for edição de postagem, carregar o texto do banco para edição...
$o_post = new Model\Post($posId);
if ($posId == 0) { $o_post->post['posVisibility'] = 1; }

$message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

// Se o Post não for do usuário que a estiver vendo, dar mensagem
if ($o_post->post['posUser'] > 0 && $o_post->post['posUser'] != $userId){
    $message = 'Essa postagem pertence a outro usuário.';
    Controller\Controller::mainAction();
}


//Controller\Log::write('Chegou até aqui...');
Controller\Log::write($posId . ' - ' . $postAction . ' - ' . $postHead);

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
            <form method="post" class="w3-container" 
                action="main.php?action=<?php echo $postAction; ?>">

                <label for="post">Postagem:</label><br>
                <textarea id="post" name="text" rows="10" cols="100" autofocus="autofocus"><?php echo $o_post->post['posText']; ?></textarea>
                <br><br>
                <p>Tipo de visibilidade:
                    <br>
                    <input type="radio" id="public" name="visibility" 
                        value="1" <?php if ($o_post->post['posVisibility'] == 1) { echo 'checked'; } ?>>
                    <label for="public">Pública</label>
                    <br>
                    <input type="radio" id="friends" name="visibility" 
                        value="2" <?php if ($o_post->post['posVisibility'] == 2) { echo 'checked'; } ?>>
                    <label for="friends">Apenas amigos</label>
                    <br>
                    <input type="radio" id="particular" name="visibility" 
                        value="3" <?php if ($o_post->post['posVisibility'] == 3) { echo 'checked'; } ?>>
                    <label for="particular">Particular</label>
                </p>
                <br>
                <input type="hidden" name="target" value="post">
                <input type="hidden" name="user" value="<?php echo $userId; ?>">
                <input type="hidden" name="id" value="<?php echo $o_post->post['posId']; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=index">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>
