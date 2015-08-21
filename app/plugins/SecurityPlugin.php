<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\Model\Query,
    Phalcon\Acl;

/**
 * Security
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{

    public function  getSessionValue($key, $arraykey, $default = '')
    {
        $yh = $this->session->get($key);
        if (isset($yh[$arraykey])) {
            return $yh[$arraykey];
        } else {
            return $this->getMSessionValue($key, $arraykey, $default);
        }
    }

    public function  getMSessionValue($key, $arraykey, $default = '')
    {
        $yh = $this->getSession($key, null);
        if (isset($yh->$arraykey)) {
            return $yh->$arraykey;
        } else {
            return $default;
        }
    }


    public function getSession($key, $default = '')
    {
        return json_decode($this->redis->get($this->getSessionId()))->$key;
    }

    public function getSessionId()
    {
        return 'oauth_access_tokens:' . $this->request->get('access_token');
    }


    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        //获取要转发的controller名称
        $controller = mb_strtolower($dispatcher->getControllerName());
        //获取要转发的action
        $action = mb_strtolower($dispatcher->getActionName());

        $annotations = $this->annotations->getMethod($dispatcher->getControllerClass(), $dispatcher->getActiveMethod());
        //是私有，开始判断私用情况，不是的话就是共有，直接返回真
        if ($annotations->has('privateResource')) {
            $annotation = $annotations->get('privateResource');
            //含有allow列表，则判断当前用户是否在allow列表中，否则，判断只要登录就返回真,未登陆用户跳转到登陆界面
            if ($annotation->hasArgument('allowYlx')) {
                $allow = $annotation->getArgument('allowYlx');
                if ($allow != '' && in_array($this->getSessionValue('user', 'type'), mb_split(',', $allow))) {
                    return true;
                } else {
                    if ($this->getSessionValue('user', 'id') == '') {
                        $this->response->redirect("session/index/?callback=" . urlencode($_SERVER[REQUEST_URI]));
                    }else{
                        $this->response->redirect("errors/show401/?callback=" . urlencode($_SERVER[REQUEST_URI]));
                    }

                    return false;
                }
            } else {
                if ($this->getSessionValue('user', 'id') != '') {
                    return true;
                } else {
                        $this->response->redirect("login?callback=" . urlencode($_SERVER[REQUEST_URI]));
                }
            }
        } else {
            return true;
        }
        //也没有在公共资源列表，则返回401未授权页面、返回false.
        return false;
    }
}
