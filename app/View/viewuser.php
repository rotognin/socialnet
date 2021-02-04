<?php

/**
 * Visualizar a página de um usuário.
 * Se for ele mesmo, redirecionar para index.php
 */

 use app\Model as Model;

$userTarget = (isset($_GET['usertarget']) && $_GET['usertarget'] > 0) ? $_GET['usertarget'] : 0;

if ($userId == $userTarget || $userTarget == 0){
    header('Location: main.php?action=main');
    exit();
}

$o_user = new Model\User($userTrget);

$isMyFriend = Model\Friendship::isFriend($userId, $userTarget);

if ($isMyFriend){
    // Carregar a amizade para pegar a data
    $friendSince = Model\Friendship::friendSince($userId, $userTarget);
}

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <h3><?php echo $o_user->user['usuId'] . ' - ' . $o_user->user['usuName']; ?></h3>
        <p><?php echo $o_user->user['usuCity'] . ' - ' . $o_user->user['usuState']; ?></p>
        <?php
            if ($isMyFriend){
                echo 'É seu amigo desde ' . DateTime($friendSince);
            }
        ?>
        <br>
        <p>
        <a class="w3-button w3-blue" href="main.php?action=listfriends&usertarget=<?php echo $o_user->user['usuId']; ?>">Amigos</a>
        <a class="w3-button w3-blue" href="main.php?action=listcommunities&usertarget=<?php echo $o_user->user['usuId']; ?>">Comunidades</a>
        <a class="w3-button w3-blue" href="main.php?action=listposts&usertarget=<?php echo $o_user->user['usuId']; ?>">Postagens</a>

        <?php
            if (!$isMyFriend){
                echo '<a class="w3-button w3-blue" href="main.php?action=addfriend&usertarget=' . $o_user->user['usuId'] . '">Amigos</a>';
            }
        ?>
        </p>
        <br>
    </div>
    
</body>
</html>