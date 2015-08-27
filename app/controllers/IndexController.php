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


    }
}
