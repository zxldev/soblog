<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class SystemsController extends ControllerBase
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
     * Searches for systems
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Systems", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $systems = Systems::find($parameters);
        if (count($systems) == 0) {
            $this->flash->notice("The search did not find any systems");

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $systems,
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
     * Edits a system
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $system = Systems::findFirstByid($id);
            if (!$system) {
                $this->flash->error("system was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "systems",
                    "action" => "index"
                ));
            }

            $this->view->id = $system->id;

            $this->tag->setDefault("id", $system->id);
            $this->tag->setDefault("cate", $system->cate);
            $this->tag->setDefault("system_name", $system->system_name);
            $this->tag->setDefault("system_value", $system->system_value);
            
        }
    }

    /**
     * Creates a new system
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "index"
            ));
        }

        $system = new Systems();

        $system->cate = $this->request->getPost("cate");
        $system->system_name = $this->request->getPost("system_name");
        $system->system_value = $this->request->getPost("system_value");
        

        if (!$system->save()) {
            foreach ($system->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "new"
            ));
        }

        $this->flash->success("system was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "systems",
            "action" => "index"
        ));

    }

    /**
     * Saves a system edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $system = Systems::findFirstByid($id);
        if (!$system) {
            $this->flash->error("system does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "index"
            ));
        }

        $system->cate = $this->request->getPost("cate");
        $system->system_name = $this->request->getPost("system_name");
        $system->system_value = $this->request->getPost("system_value");
        

        if (!$system->save()) {

            foreach ($system->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "edit",
                "params" => array($system->id)
            ));
        }

        $this->flash->success("system was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "systems",
            "action" => "index"
        ));

    }

    /**
     * Deletes a system
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $system = Systems::findFirstByid($id);
        if (!$system) {
            $this->flash->error("system was not found");

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "index"
            ));
        }

        if (!$system->delete()) {

            foreach ($system->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "systems",
                "action" => "search"
            ));
        }

        $this->flash->success("system was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "systems",
            "action" => "index"
        ));
    }

}
