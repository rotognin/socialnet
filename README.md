# Socialnet
<h3>Rede social simples usando o padrão MVC com PHP</h3>

A ideia é criar uma rede social, em um primeiro momento, simples, com usuários e comunidades.
Será possível enviar mensagens públicas ou privadas entre os usuários e participar 
de comunidades com assuntos específicos.

Esse projeto está me servindo como um estudo de PHP seguindo o padrão MVC e demais coisas que estarei
acrescentando aos meus estudos.

Inicialmente não estou me importando com o visual.
Para não ficar sem css algum, estou utilizando o w3.css da w3schools.com por ser simples e prático.

---------------------------

<h3>Executar localmente</h3>

Para rodar esse sistema localmente, siga esses passos:

1. Baixe os fontes em uma pasta
2. É necessário um servidor local com Php e MySQL (eu uso WAMP, mas pode ser XAMPP ou similares)
3. No MySQL, crie um novo banco chamado <i>socialnet_db</i>
4. Rode os scripts das tabelas que encontram-se em <i>docs\scripts</i>
5. Configure a conexão com o banco no arquivo <i>app\Model\Connection.php</i>
6. Execute o <i>index.php</i> da página principal.

---------------------------

<h3>Próximos passos:</h3>

1. (OK) Fazer um usuário participar de uma comunidade
2. (Caminhando...) Criar a página de usuários/amigos:
    - "addfriend" - Adicionar como amigo
    - "denyfriend" - Negar a amizade
    - "canceladd" - Cancelar pedido de amizade
    - "sendfriendmessage" - Enviar mensagem ao amigo
    - "undofriendship" - Desfazer amizade
3. Página de recados dos amigos - "listusermessages"
4. Respostas das postagens nas comunidades
5. Adicionar uma breve descrição para os usuários

<h3>Futuras melhorias:</h3>

1. Trocar as passagens de parâmetros por GET para SESSION
2. Abstrair comandos do Model para redução e aproveitamento de código
3. Nas views, procurar melhorar os comandos PHP antes do HTML.
    - Se for viável, retirá-los da View.