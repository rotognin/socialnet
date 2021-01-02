<?php

session_start();
$mensagem = (isset($_SESSION['mensagem'])) ? $_SESSION['mensagem'] : '';
$_SESSION['mensagem'] = '';

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
    <div class="w3-container">
        <div class="w3-card-4">
            <header class="w3-container w3-light-grey"><h3>SocialNET</h3></header>
            <div class="w3-container">
                <p>
                <form method="post" class="w3-container" action="/app/Controller/?acao=login">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login" autofocus="autofocus">
                    <br><br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha">
                    <br><br>
                    <input type="submit" value="Entrar" class="w3-button w3-blue">
                    <p><a href="/app/Controller/?acao=criar">Criar usuário</a></p>
                </form>
                </p>
            </div>
        </div>
    </div>
</body>
</html>