<?php

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
                $this->response->redirect($this->request->get('callback','/'));
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

        return $this->forward('session/index');
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
        $this->destorySession();
        $this->response->setStatusCode(200);
    }

    public static  function registerUser($uid,$source,$name=null,$email=null){
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
        $retss = $user->save();
        return $user;
    }

    /**
     */
    public function weiboLogincallbackAction()
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
            setcookie('weibojs_' . $o->client_id, http_build_query($token));
        } else {
            //授权失败。
        }

    }

}
