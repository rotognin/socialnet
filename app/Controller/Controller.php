<?php

namespace app\Controller;

use app\Model as Model;

class Controller
{
    /**
     * Realizar o login do usuário
     */
    static function loginAction(array $data)
    {
        if ($data['login'] == '' || $data['password'] == ''){
            Log::message('Login ou Senha em branco.');
            self::homeAction();
        }

        $o_user = new Model\User();
        if (!$o_user->login($data['login'], $data['password'])){
            self::homeAction();
        }

        $_SESSION['userId'] = $o_user->user['usuId'];
        $_SESSION['userName'] = $o_user->user['usuName'];

        self::mainAction();
    }

    static function logoutAction()
    {
        session_unset();
        self::homeAction();
    }

    static function homeAction()
    {
        header('Location: ' . DIR['home']);
        exit();
    }

    /**
     * Chama a página principal do usuário logado
     */
    static function mainAction()
    {
        self::viewAction('index');
    }

    /**
     * Verificação de criação de novo usuário
     */
    static function newuserAction(array $data)
    {
        UserController::newUser($data);
    }

    /**
     * Gravar postagem
     */
    static function insertuserpostAction(array $data)
    {
        PostController::insert($data);
    }

    /**
     * Atualizar postagem
     */
    static function updateuserpostAction(array $data)
    {
        PostController::update($data);
        self::viewAction('userposts');
    }

    static function listuserpostsAction()
    {
        self::viewAction('userposts');
    }

    static function listcommunitiesAction()
    {
        self::viewAction('usercommunities', 'usertarget=' . $_SESSION['userId']);
    }

    static function createcommunityAction()
    {
        self::viewAction('newcommunity');
    }

    static function newcommunityAction(array $data)
    {
        $communityId = CommunityController::insert($data);
        $_SESSION['message'] = ParticipationController::associateUser($communityId, $data['admUser']);

        self::viewAction('usercommunities', 'usertarget=' . $data['admUser']);
    }

    /**
     * Nova postagem em uma comunidade
     */
    static function newcommunitypostAction(array $postData, array $getData)
    {
        self::viewAction('communitypost', 'communityId=' . $getData['communityId']);
    }

    /**
     * Gravar postagem em uma página
     */
    static function insertcommunitypostAction(array $data)
    {
        CommunityPostController::insert($data);
    }

    /**
     * Perfil do usuário logado
     */
    static function profileAction()
    {
        self::viewAction('profile');
    }

    /**
     * Criar uma postagem de usuário
     */
    static function createuserpostAction()
    {
        self::viewAction('post');
    }

    /**
     * Editar uma postagem
     */
    static function edituserpostAction(array $postData, array $getData)
    {
        if (!array_key_exists('posId', $getData)){
            self::viewAction('userposts');
        } else {
            self::viewAction('post', 'posId=' . $getData['posId']);
        }
    }

    /**
     * Atualização do usuário
     */
    static function updateuserAction(array $data)
    {
        UserController::updateUser($data);
        self::mainAction();
    }

    /**
     * Entrar em uma comunidade
     */
    static function showcommunityAction(array $postData, array $getData)
    {
        self::viewAction('showcommunity', 'comId=' . $getData['comId']);
    }

    /**
     * Buscar comunidades
     */
    static function communitysearchAction()
    {
        self::viewAction('communitysearch');
    }

    /**
     * Passa o controle para a View
     */
    static function viewAction(string $view, string $addGet = '')
    {
        // Monta a localização da página principal com a view a ser carregada
        $location = 'socialnet.php?view=' . $view;

        if (!empty($addGet)){
            $location .= '&' . $addGet;
        }

        // Redireciona para a página principal com a página a ser carregada por lá
        header('Location: ' . $location);
    }
}