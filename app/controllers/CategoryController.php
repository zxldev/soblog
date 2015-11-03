<?php
namespace Souii\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class CategoryController extends ControllerBase
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
     * Searches for category
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "\Souii\Models\Category", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $category = \Souii\Models\Category::find($parameters);
        if (count($category) == 0) {
            $this->flash->notice("The search did not find any category");

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $category,
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
     * Edits a category
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $category = \Souii\Models\Category::findFirstByid($id);
            if (!$category) {
                $this->flash->error("category was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "category",
                    "action" => "index"
                ));
            }

            $this->view->id = $category->id;

            $this->tag->setDefault("id", $category->id);
            $this->tag->setDefault("cate_name", $category->cate_name);
            $this->tag->setDefault("as_name", $category->as_name);
            $this->tag->setDefault("parent_id", $category->parent_id);
            $this->tag->setDefault("seo_title", $category->seo_title);
            $this->tag->setDefault("seo_key", $category->seo_key);
            $this->tag->setDefault("seo_desc", $category->seo_desc);
            $this->tag->setDefault("created_at", $category->created_at);
            $this->tag->setDefault("updated_at", $category->updated_at);
            
        }
    }

    /**
     * Creates a new category
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "index"
            ));
        }

        $category = new \Souii\Models\Category();

        $category->cate_name = $this->request->getPost("cate_name");
        $category->as_name = $this->request->getPost("as_name");
        $category->parent_id = $this->request->getPost("parent_id");
        if(empty($category->parent_id)){
            $category->parent_id = 0;
        }
        $category->seo_title = $this->request->getPost("seo_title");
        $category->seo_key = $this->request->getPost("seo_key");
        $category->seo_desc = $this->request->getPost("seo_desc");
        $category->created_at = date('Y-m-d H:i:s');
        $category->updated_at = date('Y-m-d H:i:s');
        

        if (!$category->save()) {
            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "new"
            ));
        }

        $this->flash->success("category was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "category",
            "action" => "index"
        ));

    }

    /**
     * Saves a category edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $category = \Souii\Models\Category::findFirstByid($id);
        if (!$category) {
            $this->flash->error("category does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "index"
            ));
        }

        $category->cate_name = $this->request->getPost("cate_name");
        $category->as_name = $this->request->getPost("as_name");
        $category->parent_id = $this->request->getPost("parent_id");
        $category->seo_title = $this->request->getPost("seo_title");
        $category->seo_key = $this->request->getPost("seo_key");
        $category->seo_desc = $this->request->getPost("seo_desc");
        $category->created_at = $this->request->getPost("created_at");
        $category->updated_at = $this->request->getPost("updated_at");
        

        if (!$category->save()) {

            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "edit",
                "params" => array($category->id)
            ));
        }

        $this->flash->success("category was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "category",
            "action" => "index"
        ));

    }

    /**
     * Deletes a category
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $category = \Souii\Models\Category::findFirstByid($id);
        if (!$category) {
            $this->flash->error("category was not found");

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "index"
            ));
        }

        if (!$category->delete()) {

            foreach ($category->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "category",
                "action" => "search"
            ));
        }

        $this->flash->success("category was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "category",
            "action" => "index"
        ));
    }

}
