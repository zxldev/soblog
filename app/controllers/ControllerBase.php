<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Base
{

    protected function initialize()
    {
        $this->tag->prependTitle('INVO | ');
        $this->view->setVar('user',$this->getSession('user'));
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
    	return $this->dispatcher->forward(
    		array(
    			'controller' => $uriParts[0],
    			'action' => $uriParts[1],
                'params' => $params
    		)
    	);
    }
}
