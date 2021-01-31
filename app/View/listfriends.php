<?php

/**
 * Amigos do usuário visualizado
 */
use app\Model as Model;

// Usuário "alvo", de quem está listando as amizades
$userTarget = (isset($_GET['usertarget']) && $_GET['usertarget'] > 0) ? $_GET['usertarget'] : $userId;

$_SESSION['userTarget'] = $userTarget;

$message = $_SESSION['message'];
$_SESSION['message'] = '';

$sameUser = ($userId == $userTarget);

$o_friendship = new Model\Friendship();
$userFriendships = $o_friendship->list($userTarget);

$titlePage = ($sameUser) ? 'Minhas Comunidades' : 'Comunidades de ' . Model\User::findName($userTarget);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-margin">
        <header class="w3-container w3-light-grey"><h3><?php echo $titlePage; ?></h3></header>
        <?php
           if ($sameUser) {
               echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=communitysearch">Procurar Comunidades</a>';
               echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=createcommunity">Criar Comunidade</a>';
           }
        ?>
        <a class="w3-button w3-blue w3-margin" href="socialnet.php?view=index">Voltar</a>

        <div class="w3-container">
        
        <?php 
            foreach($userCommunities as $community){
                $html  = '';
                $html .= '<div class="w3-container w3-card-4 w3-padding w3-hover-light-grey">';
                $html .= 'ID: ' . $community['comId'] . ' - Nome: <b><a href="main.php?action=showcommunity&comId=' . $community['comId'] . '">' . $community['comName'] . '</a></b>';

                if ($community['comAdmUser'] == $userTarget){
                    $html .= '<i> - Administrador</i>';
                }

                $html .= '<br>';
                $html .= 'Descrição: <i>' . nl2br($community['comDescription']) . '</i></div><br>';
                echo $html;
            }
        ?>
        
        </div>
        <div><?php echo $message; ?></div>
    </div>
</body>
</html>