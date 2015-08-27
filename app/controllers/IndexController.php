<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Welcome');
        parent::initialize();
        $this->view->setTemplateAfter('header');
    }

    public function indexAction()
    {
//        $client = new \Github\Client();
//        $client->authenticate('390a59f1b709bcc1d4f7b77203cac967d9a375d3',null,\Github\Client::AUTH_HTTP_TOKEN);
////        $ret = $client->api('current_user')->update(array(
////            'location' => 'china',
////            'blog'     => 'http://souii.com'
////        ));
//        $this->flash->success(json_encode($ret));

    }
}
