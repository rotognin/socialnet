<?php

/**
 * Comunidades que o usuário participa.
 */
use app\Model as Model;

// Usuário logado
$userId = (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) ? $_SESSION['userId'] : 0;

if ($userId == 0) {
    header('Location: index.php');
    exit();
}

// Usuário "alvo", de quem está listando as comunidades
$userTarget = (isset($_GET['usertarget']) && $_GET['usertarget'] > 0) ? $_GET['usertarget'] : 0;

if ($userTarget == 0) {
    header('Location: index.php');
    exit();
}

$message = $_SESSION['message'];
$_SESSION['message'] = '';

$sameUser = ($userId == $userTarget);

$o_community = new Model\Community();
$userCommunities = $o_community->list(COM_TL_USERPARTICIPATE, 0, $userTarget, '', 'DESC');

$titlePage = ($sameUser) ? 'Minhas Comunidades' : 'Comunidades de ' . Model\User::findName($userTarget);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <header class="w3-container w3-light-grey"><h3><?php echo $titlePage; ?></h3></header>
        <?php
           if ($sameUser) {
               echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=communitysearch">Procurar Comunidades</a>';
               echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=createcommunity">Criar Comunidade</a>';
           }
        ?>
        <div class="w3-container">
        <?php 
            foreach($userCommunities as $community){
                $html  = '';
                $html .= '<div class="w3-container w3-card-4 w3-padding w3-hover-light-grey">';
                $html .= 'ID: ' . $community['comId'] . ' - Nome: <b><a href="main.php?action=showcommunity&comId=' . $community['comId'] . '">' . $community['comName'] . '</a></b><br>';
                $html .= 'Descrição: <i>' . nl2br($community['comDescription']) . '</i></div><br>';
                echo $html;
            }
        ?>
        <p><a href="socialnet.php?view=index">Voltar</a></p>
    </div>
    <div><?php echo $message; ?></div>
</body>
</html>