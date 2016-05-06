<?php
namespace Souii\Controllers;
use Souii\Models\Users as Users;
use Souii\Github\Users as GithubUsers;
use Souii\Github\OAuth;
use Phalcon\Mvc\Model as Model;
/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('header');
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
            $user = $this->getSession('user',false);
            if($user){
                $this->response->redirect($this->request->get('callback',null,'/'));
            }
            $this->tag->setDefault('callback', $this->request->get('callback'));
            $url = $this->weiboOauth->getAuthorizeURL($this->config->thirdpart['weibo']['WB_CALLBACK_URL']);
            $this->view->setVar('weiboCallBack',$url);
        }else{

        }
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user
     */
    public  function _registerSession(Users $user)
    {
        $this->setSession('user',array('id'=>$user->id,
        'name'=>$user->name,
        'email'=>$user->email,
        'type'=>$user->type,
        'uid'=>$user->uid,
        'source'=>$user->source));
    }



    /**
     * This action authenticate and logs an user into the application
     *
     */
    public function startAction()
    {
        if ($this->request->isPost()) {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $callback = $this->request->getPost('callback',null,'/');

            $user = Users::findFirst(array(
                "(email = :email: OR name = :email:) AND password = :password:",
                'bind' => array('email' => $email, 'password' => sha1($password))
            ));
            if ($user != false) {
                $this->_registerSession($user);
                $this->flash->success('欢迎 ' . $user->name);
                return $this->forward($callback);
            }

            $this->flash->error('用户名或密码错误！');
        }

        return $this->forward('/session/index');
    }


    public static  function registerUser($uid,$source,$name=null,$email=null,$photo = null){
        $user = Users::findFirst(
            array( "conditions" => "uid=:uid: and source=:source:", "bind" => array('uid'=>$uid,'source'=>$source) )
        );
        if($user){
            return $user;
        }
        $user  =new Users();
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->password = '000000';
        if($name!=null){
            $user->name = $name;
        }else{
            $user->name = $uid;
        }
        $user->uid = $uid;
        $user->source = $source;
        $user->type = Users::USER_TYPE_REGISTER_USER;
        if($email!=null){
            $user->email = $email;
        }
        if($photo!=null){
            $user->photo = $photo;
        }
        $retss = $user->save();
        return $user;
    }

    /**
     * 微博登陆
     */
    public function weibologincallbackAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        $o = $this->weiboOauth;

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = $this->config->thirdpart['weibo']['WB_CALLBACK_URL'];
            try {
                $token = $o->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
            }
        }

        if ($token) {
            //登陆
            $user = SessionController::registerUser($token['uid'],Users::USER_SOURCE_WEIBO);
            $this->_registerSession($user);
            $this->setSession('token',$token);
            $this->setSession('tokentype',Users::USER_SOURCE_WEIBO);
            setcookie('weibojs_' . $o->client_id, http_build_query($token));
        } else {
            //授权失败。
        }

    }

    /**
     * qq登陆
     */
    public function qqlogincallbackAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        if (isset($_REQUEST['access_token'])) {
            echo $_REQUEST['access_token'];
        }
    }

    public function githubloginAction()
    {

        if (!$this->getSession('tokentype','')==Users::USER_SOURCE_GITHUB) {
            $oauth = new OAuth($this->config->thirdpart->github);
            return $oauth->authorize();
        }

        return $this->discussionsRedirect();
    }

    /**
     * Returns to the discussion
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    protected function discussionsRedirect()
    {
        $referer = $this->request->getHTTPReferer();
        $path    = parse_url($referer, PHP_URL_PATH);
        if ($path) {
            $this->router->handle($path);
            return $this->router->wasMatched() ? $this->response->redirect($path, true) : $this->indexRedirect();
        } else {
            return $this->indexRedirect();
        }
    }

    protected function indexRedirect()
    {
        return $this->response->redirect('/');
    }

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function githubAccessTokenAction()
    {
        $oauth = new OAuth($this->config->thirdpart->github);

        $response = $oauth->accessToken();
        if (is_array($response)) {

            if (isset($response['error'])) {
                $this->flashSession->error('Github: ' . $response['error']);
                return $this->indexRedirect();
            }

            $githubUser = new GithubUsers($response['access_token']);

            if (!$githubUser->isValid()) {
                $this->flashSession->error('Invalid Github response. Please try again');
                return $this->indexRedirect();
            }

            /**
             * Edit/Create the user
             */
            $user = Users::findFirstByUid($githubUser->getId());
            if ($user == false) {
                $user               = new Users();
                $user->uid = $githubUser->getId();
                $user->source = Users::USER_SOURCE_GITHUB;
                $user->remember_token =  $response['access_token'];
                $user->type = Users::USER_TYPE_REGISTER_USER;
                $user->created_at = date('Y-m-d H:i:s');
                $user->updated_at = date('Y-m-d H:i:s');
                $user->password = '000000';
//                $user->token_type   = $response['token_type'];
//                $user->access_token = $response['access_token'];
            }

//            if ($user->banned == 'Y') {
//                $this->flashSession->error('You have been banned from the forum.');
//                return $this->indexRedirect();
//            }

            //$user = ForumUsers::findFirst();

            // Update session id
            session_regenerate_id(true);

            /**
             * Update the user information
             */
            $user->name  = $githubUser->getName();
//            $user->login = $githubUser->getLogin();
            $email       = $githubUser->getEmail();

            if (is_string($email)) {
                $user->email = $email;
            } else {
                if (is_array($email)) {
                    if (isset($email['email'])) {
                        $user->email = $email['email'];
                    }
                }
            }

//            $user->gravatar_id = $githubUser->getGravatarId();
//            if (!$user->gravatar_id) {
//                if ($user->email && strpos($user->email, '@') !== false) {
//                    $user->gravatar_id = md5(strtolower($user->email));
//                }
//            }
//
//            $user->increaseKarma(Karma::LOGIN);

            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->flashSession->error((string)$message);
                    return $this->indexRedirect();
                }
            }

            /**
             * Store the user data in session
             */
//            $this->session->set('identity', $user->id);
//            $this->session->set('identity-name', $user->name);
//            $this->session->set('identity-gravatar', $user->gravatar_id);
//            $this->session->set('identity-timezone', $user->timezone);
//            $this->session->set('identity-theme', $user->theme);
//            $this->session->set('identity-moderator', $user->moderator);
            $this->_registerSession($user);
            $this->setSession('token',$response['access_token']);
            $this->setSession('tokentype',Users::USER_SOURCE_GITHUB);
            if ($user->getOperationMade() ==  Model::OP_CREATE) {
                $this->flashSession->success('Welcome ' . $user->name);
            } else {
                $this->flashSession->success('Welcome back ' . $user->name);
            }

//            if ($user->email && strpos($user->email, '@') !== false) {
//
//                if (strpos($user->email, '@users.noreply.github.com') !== false) {
//                    $messageNotAlllow = 'Your current e-mail: ' . $this->escaper->escapeHtml($user->email)
//                        . ' does not allow us to send you e-mail notifications';
//                    $this->flashSession->notice($messageNotAlllow);
//                }
//            } else {
//
//                $messageCantSend
//                    = 'We weren\'t able to obtain your e-mail address'
//                    . ' from Github, we can\'t send you e-mail notifications';
//                $this->flashSession->notice($messageCantSend);
//            }
            return $this->discussionsRedirect();
        }

        $this->flashSession->error('Invalid Github response. Please try again');
        return $this->discussionsRedirect();
    }
}
