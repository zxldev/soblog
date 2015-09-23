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
    private function _registerSession(Users $user)
    {
        $this->setSession('user',array('id'=>$user->id,
        'name'=>$user->name,
        'email'=>$user->email,
        'type'=>$user->type));
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
}
