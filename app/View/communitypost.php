<?php

use app\Model as Model;
use app\Controller as Controller;

$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

$communityId = $_GET['communityId'];

$o_community = new Model\Community($communityId);

$postAction = 'insertcommunitypost';

$message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Nova postagem na comunidade:</h3></header>
        <p><i><?php echo $o_community->community['comName']; ?></i></p>
        <div class="w3-container">
            <p>
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
