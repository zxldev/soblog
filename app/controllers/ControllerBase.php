<?php
namespace Souii\Controllers;
use Souii\Models;
use Phalcon\Mvc\Controller;

class ControllerBase extends Base
{

    protected function initialize()
    {

        $this->tag->prependTitle($this->elements->getSysVar('siteName').'| ');
        $this->view->setVar('user',$this->getSession('user'));
    }

    protected function forward($uri)
    {
        if(substr($uri,0,1)=='/')
            $uri = substr($uri,1,strlen($uri));
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
    	return $this->dispatcher->forward(
    		array(
    			'controller' => $uriParts[0],
    			'action' =>isset($uriParts[1])?$uriParts[1]:'' ,
                'params' => $params
    		)
    	);
    }
}
