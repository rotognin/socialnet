<?php

use app\Model as Model;
use app\Controller as Controller;

$idCpo = $_GET['postid'];
$idCommunity = $_GET['communityid'];

// Se for editar a resposta, trazer o ID da resposta
$cprId = 0;
$o_communityResponse = new Model\CommunityResponse($cprId);

$responseAction = 'insertpostresponse';

$message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Responder à postagem</h3></header>
        <div class="w3-container">
            <p>
            <form method="post" class="w3-container" 
                action="main.php?action=<?php echo $responseAction; ?>">

                <label for="text">Resposta:</label><br>
                <textarea id="text" name="text" rows="10" cols="100" autofocus="autofocus"><?php echo $o_communityResponse->communityResponse['cprText']; ?></textarea>
                <br>
                <input type="hidden" name="target" value="communityresponse">
                <input type="hidden" name="idUser" value="<?php echo $userId; ?>">
                <input type="hidden" name="idCpo" value="<?php echo $$idCpo; ?>">
                <input type="submit" value="Gravar" class="w3-button w3-blue">
                <p><a href="socialnet.php?view=showcommunity&comId=<?php echo $idCommunity; ?>">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>
