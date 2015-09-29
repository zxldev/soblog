<?php
namespace Souii\Controllers;
use Souii\Models;
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 15-1-30
 * Time: 下午5:24
 */
use Phalcon\Mvc\Controller;

class Base extends Controller implements ISessionInterface
{

//    /**
//     * Execute before the router so we can determine if this is a provate controller, and must be authenticated, or a
//     * public controller that is open to all.
//     *
//     * @param Dispatcher $dispatcher
//     * @return boolean
//     */
//    public function beforeExecuteRoute(Dispatcher $dispatcher)
//    {
//        $controllerName = $dispatcher->getControllerName();
//
//        // Only check permissions on private controllers
//        if ($this->acl->isPrivate($controllerName)) {
//
//            // Get the current identity
//            $identity = $this->auth->getIdentity();
//
//            // If there is no identity available the user is redirected to index/index
//            if (!is_array($identity)) {
//
//                $this->flash->notice('You don\'t have access to this module: private');
//
//                $dispatcher->forward(array(
//                    'controller' => 'index',
//                    'action' => 'index'
//                ));
//                return false;
//            }
//
//            // Check if the user have permission to the current option
//            $actionName = $dispatcher->getActionName();
//            if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
//
//                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);
//
//                if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
//                    $dispatcher->forward(array(
//                        'controller' => $controllerName,
//                        'action' => 'index'
//                    ));
//                } else {
//                    $dispatcher->forward(array(
//                        'controller' => 'user_control',
//                        'action' => 'index'
//                    ));
//                }
//
//                return false;
//            }
//        }
//    }


    public function  getSessionValue($key, $arraykey,$default = '')
    {
        $yh = $this->session->get($key);
        if(isset( $yh[$arraykey])){
            return $yh[$arraykey];
        }else{
            return $default;
        }
    }

    public function setSession($key,$value){
        $this->session->set($key,$value);
    }

    public function getSession($key, $default = ''){
        return $this->session->get($key,$default);
    }

    public function getSessionId(){
        return $this->session->getId();
    }

    public function destorySession(){
        $this->session->destroy();
    }
}