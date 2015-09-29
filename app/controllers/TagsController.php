<?php
namespace Souii\Controllers;
use Souii\Models;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class TagsController extends ControllerBase
{


    public function initialize()
{
    $this->tag->setTitle('');
    parent::initialize();
    $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
    $this->view->setTemplateAfter('backend');

}

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for tags
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Souii\Models\Tags", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $tags = Tags::find($parameters);
        if (count($tags) == 0) {
            $this->flash->notice("The search did not find any tags");

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $tags,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a tag
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $tag = Tags::findFirstByid($id);
            if (!$tag) {
                $this->flash->error("tag was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "tags",
                    "action" => "index"
                ));
            }

            $this->view->id = $tag->id;

            $this->tag->setDefault("id", $tag->id);
            $this->tag->setDefault("name", $tag->name);
            $this->tag->setDefault("number", $tag->number);
            
        }
    }

    /**
     * Creates a new tag
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "index"
            ));
        }

        $tag = new Tags();

        $tag->name = $this->request->getPost("name");
        $tag->number = $this->request->getPost("number");
        

        if (!$tag->save()) {
            foreach ($tag->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "new"
            ));
        }

        $this->flash->success("tag was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tags",
            "action" => "index"
        ));

    }

    /**
     * Saves a tag edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $tag = Tags::findFirstByid($id);
        if (!$tag) {
            $this->flash->error("tag does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "index"
            ));
        }

        $tag->name = $this->request->getPost("name");
        $tag->number = $this->request->getPost("number");
        

        if (!$tag->save()) {

            foreach ($tag->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "edit",
                "params" => array($tag->id)
            ));
        }

        $this->flash->success("tag was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tags",
            "action" => "index"
        ));

    }

    /**
     * Deletes a tag
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $tag = Tags::findFirstByid($id);
        if (!$tag) {
            $this->flash->error("tag was not found");

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "index"
            ));
        }

        if (!$tag->delete()) {

            foreach ($tag->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "tags",
                "action" => "search"
            ));
        }

        $this->flash->success("tag was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "tags",
            "action" => "index"
        ));
    }

}
