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
$userFriendships = $o_friendship->list($userTarget, FRI_TL_DONE);

// Trazer amizades pendentes para eu aceitar, pendentes que eu solicitei, e as que eu neguei a amizade
if ($sameUser){
    // Pendentes para eu aceitar
    $friendshipsPendingTo = $o_friendship->list($userTarget, FRI_TL_PENDING_TO);

    // Pendentes que eu solicitei
    $friendshipsPendingFrom = $o_friendship->list($userTarget, FRI_TL_PENDING_FROM);

    // Amizades que eu neguei
    $friendshipsDeniedFrom = $o_friendship->list($userTarget, FRI_TL_DENIED_FROM);
}

$titlePage = ($sameUser) ? 'Minhas Amizades' : 'Amizades de ' . Model\User::findName($userTarget);

// Saber se o usuário alvo é meu amigo
if (!$sameUser){
    $isMyFriend = $o_friendship->isFriend($userId, $userTarget);
}

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-margin">
        <header class="w3-container w3-light-grey"><h3><?php echo $titlePage; ?></h3></header>
        <?php
           if (!$sameUser) {
               if ($isMyFriend){
                   echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=sendfriendmessage">Enviar mensagem</a>';
                   echo '<a class="w3-button w3-red w3-margin" href="main.php?action=undofriendship">Desfazer Amizade</a>';
               } else {
                echo '<a class="w3-button w3-red w3-margin" href="main.php?action=addfriend">Adicionar Amigo</a>';
               }
           }
        ?>
        <a class="w3-button w3-blue w3-margin" href="socialnet.php?view=index">Voltar</a>

        <div class="w3-container">
        
        <?php 
            foreach($userFriendships as $friendship){
                $usuId    = ($friendship['usuOriginId'] == $userTarget) ? $friendship['usuDestinationId']    : $friendship['usuOriginId'];
                $usuName  = ($friendship['usuOriginId'] == $userTarget) ? $friendship['usuDestinationName']  : $friendship['usuOriginName'];
                $usuCity  = ($friendship['usuOriginId'] == $userTarget) ? $friendship['usuDestinationCity']  : $friendship['usuOriginCity'];
                $usuState = ($friendship['usuOriginId'] == $userTarget) ? $friendship['usuDestinationState'] : $friendship['usuOriginState'];

                echo '<div class="w3-quarter w3-container w3-padding">';
                echo '<p>';
                echo '<a href="socialnet.php?view=listfriends&usertarget=' . $usuId . '">';
                echo '<b>' . $usuName . '</b>';
                echo '</a>';
                echo '<br>' . $usuCity . ', ' . $usuState . '</p>';
                echo '</div>';
            }
        ?>
        
        </div>

        <?php
            if ($sameUser){
                echo '<h3>Amizades pendentes para aceitação:</h3><br>';

                foreach($friendshipsPendingTo as $friendPendingTo){
                    echo '<div class="w3-quarter w3-container w3-padding">';
                    echo '<p>';
                    echo '<a href="socialnet.php?view=listfriends&usertarget=' . $friendPendingTo['usuDestinationId'] . '">';
                    echo '<b>' . $friendPendingTo['usuDestinationName'] . '</b>';
                    echo '</a>';
                    echo '<br>' . $friendPendingTo['usuDestinationCity'] . ', ' . $friendPendingTo['usuDestinationState'] . '</p>';
                    echo '<a class="w3-button w3-red w3-margin" href="main.php?action=addfriend">Aceitar</a>';
                    echo '<a class="w3-button w3-red w3-margin" href="main.php?action=denyfriend">Negar</a>';
                    echo '</div>';
                }

                echo '<h3>Convites em aberto:</h3><br>';

                foreach($friendshipsPendingFrom as $friendPendingFrom){
                    echo '<div class="w3-quarter w3-container w3-padding">';
                    echo '<p>';
                    echo '<a href="socialnet.php?view=listfriends&usertarget=' . $friendPendingFrom['usuDestinationId'] . '">';
                    echo '<b>' . $friendPendingFrom['usuDestinationName'] . '</b>';
                    echo '</a>';
                    echo '<br>' . $friendPendingFrom['usuDestinationCity'] . ', ' . $friendPendingFrom['usuDestinationState'] . '</p>';
                    echo '<a class="w3-button w3-red w3-margin" href="main.php?action=canceladd">Cancelar</a>';
                    echo '</div>';
                }

                echo '<h3>Amizades Negadas:</h3><br>';

                foreach($friendshipsDeniedFrom as $friendDeniedFrom){
                    echo '<div class="w3-quarter w3-container w3-padding">';
                    echo '<p>';
                    echo '<a href="socialnet.php?view=listfriends&usertarget=' . $friendDeniedFrom['usuDestinationId'] . '">';
                    echo '<b>' . $friendDeniedFrom['usuDestinationName'] . '</b>';
                    echo '</a>';
                    echo '<br>' . $friendDeniedFrom['usuDestinationCity'] . ', ' . $friendDeniedFrom['usuDestinationState'] . '</p>';
                    echo '<a class="w3-button w3-red w3-margin" href="main.php?action=addfriend">Aceitar</a>';
                    echo '</div>';
                }
            }
        ?>

        <div><?php echo $message; ?></div>
    </div>
</body>
</html>