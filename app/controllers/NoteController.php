<?php
namespace Souii\Controllers;
use Phalcon\Annotations\Exception;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class NoteController extends ControllerBase
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
     * Searches for note
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "\Souii\Models\Note", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $note = \Souii\Models\Note::find($parameters);
        if (count($note) == 0) {
            $this->flash->notice("The search did not find any note");

            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $note,
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
     * Edits a note
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $note = \Souii\Models\Note::findFirstByid($id);
            if (!$note) {
                $this->flash->error("note was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "note",
                    "action" => "index"
                ));
            }

            $this->view->id = $note->id;

            $this->tag->setDefault("id", $note->id);
            $this->tag->setDefault("content", $note->content);
            $this->tag->setDefault("created_at", $note->created_at);
            $this->tag->setDefault("state", $note->state);
            $this->tag->setDefault("type", $note->type);
            
        }
    }

    /**
     * Creates a new note
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "index"
            ));
        }

        $note = new \Souii\Models\Note();

        $note->content = $this->request->getPost("content");
        $note->created_at = date('Y-m-d H:i:s');
        $note->state = 1;
        $note->type = 'note';

try{
    if (!$note->save()) {
        foreach ($note->getMessages() as $message) {
            $this->flash->error($message);
        }

        return $this->dispatcher->forward(array(
            "controller" => "note",
            "action" => "new"
        ));
    }
}catch (Exception $s){
    $ss = $s;
}


        $this->flash->success("note was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "note",
            "action" => "index"
        ));

    }

    /**
     * Saves a note edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $note = \Souii\Models\Note::findFirstByid($id);
        if (!$note) {
            $this->flash->error("note does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "index"
            ));
        }

        $note->id = $this->request->getPost("id");
        $note->content = $this->request->getPost("content");
        $note->created_at = $this->request->getPost("created_at");
        $note->state = $this->request->getPost("state");
        $note->type = $this->request->getPost("type");
        

        if (!$note->save()) {

            foreach ($note->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "edit",
                "params" => array($note->id)
            ));
        }

        $this->flash->success("note was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "note",
            "action" => "index"
        ));

    }

    /**
     * Deletes a note
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $note = \Souii\Models\Note::findFirstByid($id);
        if (!$note) {
            $this->flash->error("note was not found");

            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "index"
            ));
        }

        if (!$note->delete()) {

            foreach ($note->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "note",
                "action" => "search"
            ));
        }

        $this->flash->success("note was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "note",
            "action" => "index"
        ));
    }

}
