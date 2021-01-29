<?php

/**
 * Listar comunidades que o usuário ainda não participa (lista simples)
 * - Posteriormente implementar colocando se algum amigo participa dela, colocar paginação, etc
 */

use app\Model as Model;

$o_communities = new Model\Community();
$communities = $o_communities->list(COM_TL_USERNOTPARTICIPATING, 0, $userId, '', 'DESC');

//var_dump($communities);

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<body>
    <div class="w3-container w3-margin">
        <header class="w3-container w3-light-grey"><h3>Buscar Comunidades:</h3></header>
        <a class="w3-button w3-blue w3-margin" href="socialnet.php?view=usercommunities">Voltar</a>

        <div class="w3-container">
        
        <?php 
            foreach($communities as $community){
                $html  = '';
                $html .= '<div class="w3-container w3-card-4 w3-padding w3-hover-light-grey">';
                $html .= 'ID: ' . $community['comId'] . ' - <b><a href="main.php?action=showcommunity&comId=' . $community['comId'] . '">' . $community['comName'] . '</a></b>';
                $html .= '<br>';
                $html .= 'Administrada por: ' . $community['usuName'] . ' - Criada em ' . DateTime($community['comDateCreation']); 
                $html .= '<br>';
                $html .= 'Descrição: <i>' . nl2br($community['comDescription']) . '</i></div><br>';
                echo $html;
            }
        ?>
        
        </div>
    </div>
</body>
</html>