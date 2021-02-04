<?php

/**
 * Tela da comunidade exibida
 */
use app\Model as Model;

$communityId = (isset($_GET['comId']) && $_GET['comId'] > 0) ? $_GET['comId'] : 0;

if ($communityId == 0) {
    header('Location: socialnet.php?view=usercommunities&usertarget=' . $userId);
    Exit();
}

$userTarget = (isset($_SESSION['userTarget']) && $_SESSION['userTarget'] > 0) ? $_SESSION['userTarget'] : $userId;
$_SESSION['userTarget'] = 0;

$o_community = new Model\Community($communityId);

$userIsAdmin = ($userId == $o_community->community['comAdmUser']);

$communityPosts       = Model\CommunityPost::listPosts($communityId);
$comunityParticipants = Model\Participation::listParticipants($communityId);

if (!$userIsAdmin){
    $isParticipating = Model\Participation::isParticipating($userId, $communityId);
}

$isActive = ($o_community->community['comStatus'] == 1);

$message = (isset($_SESSION['message'])) ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-card-4">
        <header class="w3-container w3-light-grey">
            <h3><?php echo $o_community->community['comName']; ?></h3>
            <?php
                if ($userIsAdmin) { echo ' - <i>Administrador</i>'; } 
            ?>
        
            <div class="w3-container w3-padding">
                <i><?php echo $o_community->community['comDescription']; ?></i>
            </div>
        </header>
    </div>

    <?php include_once 'public/include/mensagem.php'; ?>

    <div class="w3-container w3-card-4">

        <!-- Se o usuário não faz parte da comunidade, exibir o botão "Participar" -->
        <?php
            if ($isActive){
                if ($isParticipating) {
                    echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=newcommunitypost&communityId=' . $communityId .'">Nova Postagem</a>';
                } else {
                    echo '<a class="w3-button w3-blue w3-margin" href="main.php?action=participate&communityId=' . $communityId .'">Participar da Comunidade</a>';
                }
            }
        ?>
        
        <a class="w3-button w3-blue w3-margin" href="main.php?action=main" onclick="goBack();">Voltar</a>
    </div>

    <?php
        if ($isActive){
        ?>
            <!-- Exibir os participantes da comunidade em quadros, dividindo a página em 4 colunas -->
            <div class="w3-container w3-padding">
                <h3>Participantes:</h3>
                <?php
                    foreach ($comunityParticipants as $participant)
                    {
                        echo '<div class="w3-quarter w3-container w3-padding">';
                        echo '<p><b><a href="main.php?action=viewuser&usertarget=' . $participant['usuId'] . '">' . $participant['usuName'] . '</a></b>';

                        if ($participant['usuId'] == $participant['comAdmUser']){
                            echo '<i> - Administrador</i>';
                        }

                        echo '<br>' . $participant['usuCity'] . ', ' . $participant['usuState'] . '</p>';
                        echo '</div>';
                    }
                ?>
            </div>

            <hr>

            <!-- Exibir as postagens da comunidade, mostrando a mais recente primeiro -->
            <div class="w3-container w3-padding">
                <h3>Postagens:</h3>
                <?php
                    if (!$isParticipating && $o_community->community['comVisibility'] == 2){
                        echo '<p>As postagens dessa comunidade são privadas.<br>';
                        echo 'Apenas os participantes podem enxergá-las.</p>';
                    } else {
                        foreach ($communityPosts as $post)
                        {
                            echo '<div class="w3-half w3-container w3-padding">';
                            echo '<p>';
                            echo '<b>' . $post['usuName'] . ' - ' . DateTime($post['cpoDate']) . '</b><br>';
                            echo nl2br($post['cpoText']);
                            echo '</p>';
                            if ($isParticipating){
                                echo '<a class="w3-button w3-tiny w3-blue" href="main.php?action=replypost&post=' . $post['cpoId'] . '">Responder</a>';
                            }
                            echo '</div>';
                        }
                    }
                ?>
            </div>
        <?php
        } else {
            echo '<p>Comunidade inativa.</p>';
        }
    ?>

</body>
</html>