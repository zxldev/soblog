<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('欢迎');
        parent::initialize();
        $this->view->setTemplateAfter('header');
    }

    public function indexAction()
    {


    }
}
