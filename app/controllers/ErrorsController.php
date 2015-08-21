<?php

class ErrorsController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('header');
        $this->tag->setTitle('Oops!');
        parent::initialize();
    }

    public function show404Action()
    {

    }

    public function show401Action()
    {

    }

    public function show500Action()
    {

    }
}
