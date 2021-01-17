<?php

/**
 * Criação de nova comunidade
 */

use app\Model as Model;
use app\Controller as Controller;

$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

$o_community = new Model\Community;



?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Criação de nova comunidade</h3></header>
        <div class="w3-container">
            <p>
                <form method="post" class="w3-container" action="main.php?action=newcommunity">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="">
                <br><br>
                <label for="description">Descrição:</label>
                <input type="text" id="description" name="description" value="">
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
                </p>
                <input type="hidden" name="admUser" value="<?php echo $userId; ?>">
                <input type="hidden" name="status" value="1">
                <input type="hidden" name="acceptance" value="1">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=index">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>