<?php
namespace Souii\Controllers;
use Phalcon\Paginator\Adapter\Model as Paginator;

class UserController extends ControllerBase
{


    public function initialize()
    {
        $this->persistent->parameters = null;
        $this->tag->setTitle('');
        parent::initialize();
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $this->view->setTemplateAfter('backend');
    }

    /**
     * Edits a system
     *
     * @param string $id
     */
    public function infoAction()
    {

    }

}
