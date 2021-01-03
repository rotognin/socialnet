<?php
/**
 * Página principal do usuário logado
 * Será tipo um "Dashboard" com as informações da pessoa, as atividades
 * de seus amigos e postagens feitas nas comunidades que ele participa
 */



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>SocialNET - Pessoas conectadas</title>

   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="public/style/w3.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="w3-container w3-card-4 w3-margin">
        <h3>Página principal</h3>
        <p><?php echo $_SESSION['userId']; ?></p>
        <p><?php echo $_SESSION['userName']; ?></p>
        <br>
        <p><a href="main.php?action=logout">Sair</a></p>
    </div>
</body>
</html>