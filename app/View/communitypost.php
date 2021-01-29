<?php

use app\Model as Model;
use app\Controller as Controller;

$communityId = $_GET['communityId'];
$o_community = new Model\Community($communityId);

// Se for editar a postagem, trazer o ID da postagem
$cpoId = 0;
$o_communityPost = new Model\CommunityPost($cpoId);

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

                <label for="text">Postagem:</label><br>
                <textarea id="text" name="text" rows="10" cols="100" autofocus="autofocus"><?php echo $o_communityPost->communityPost['cpoText']; ?></textarea>
                <br>
                <input type="hidden" name="target" value="communitypost">
                <input type="hidden" name="idUser" value="<?php echo $userId; ?>">
                <input type="hidden" name="idCommunity" value="<?php echo $o_community->community['comId'] ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=index">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>
