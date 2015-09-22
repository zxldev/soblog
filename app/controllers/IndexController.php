<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('欢迎');
        parent::initialize();
        $this->view->setTemplateAfter('header');
    }

    /**
     * @Route("/tag={tag}", methods={"GET"}, name="index")
     * @param string $tag
     */
    public function indexAction($tag = '')
    {
        $this->tag->setDefault("tag", $tag);
//        $this->view->tag = $tag;
    }
}
