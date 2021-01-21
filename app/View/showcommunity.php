<?php

/**
 * Tela da comunidade exibida
 */
use app\Model as Model;

// Usuário logado
$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

$communityId = (isset($_GET['comId']) && $_GET['comId'] > 0) ? $_GET['comId'] : 0;

if ($communityId == 0) {
    header('Location: socialnet.php?view=usercommunities&usertarget=' . $userId);
    Exit();
}

$userTarget = (isset($_SESSION['userTarget']) && $_SESSION['userTarget'] > 0) ? $_SESSION['userTarget'] : $userId;
$_SESSION['userTarget'] = 0;

$o_community = new Model\Community($communityId);

$userIsAdmin = ($userId == $o_community->community['comAdmUser']);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4">
        <header class="w3-container w3-light-grey">
            <h3><?php echo $o_community->community['comName']; ?></h3>
            <?php if ($userIsAdmin) { echo ' - <i>Administrador</i>'; } ?>
        
            <div class="w3-container w3-padding">
                <i><?php echo $o_community->community['comDescription']; ?></i>
            </div>
        </header>
    </div>
    <div class="w3-container w3-card-4">
        <a class="w3-button w3-blue w3-margin" href="main.php?action=newcommunitypost&communityId=<?php echo $communityId; ?>">Nova Postagem</a>
        
        <!-- Verificar essa volta... -->
        <a class="w3-button w3-blue w3-margin" href="main.php?action=listcommunities&usertarget=<?php echo $userTarget; ?>">Voltar</a>
    </div>

    <!-- Carregar as postagens da comunidade, mostrando a mais recente primeiro -->

   
</body>
</html>