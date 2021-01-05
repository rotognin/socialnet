<?php

/**
 * Página de criação de Usuário
 */

session_start();
$message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : '';
$_SESSION['message'] = '';

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
        <header class="w3-container w3-light-grey w3-margin-top"><h3>Crie o seu usuário na SocialNET</h3></header>
        <div class="w3-container">
            <p>
            <form method="post" class="w3-container" action="main.php?action=newuser">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" autofocus="autofocus" required>
                <br><br>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" autofocus="autofocus">
                <span><i>(Apenas letras e números)</i></span>
                <br><br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password">
                <br><br>
                <input type="submit" value="Criar" class="w3-button w3-blue">
                <p><a href="index.php">Voltar</a></p>
            </form>
            </p>
        </div>
        <?php include_once 'public/include/mensagem.php'; ?>
    </div>
</body>
</html>