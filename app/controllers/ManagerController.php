<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ManagerController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('文字列表');
        parent::initialize();
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $this->view->setTemplateAfter('backend');

    }

    /**
     * Index action
     */
    public function indexAction()
    {
    }

    /**
     * Searches for article
     */
    public function searchAction($numberPage = 1)
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Article", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $article = Article::find($parameters);
        if (count($article) == 0) {
            $this->flash->notice("The search did not find any article");

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $article,
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
     * Edits a article
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $article = Article::findFirstByid($id);
            if (!$article) {
                $this->flash->error("article was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "article",
                    "action" => "index"
                ));
            }

            $this->view->id = $article->id;

            $this->tag->setDefault("id", $article->id);
            $this->tag->setDefault("cate_id", $article->cate_id);
            $this->tag->setDefault("user_id", $article->user_id);
            $this->tag->setDefault("title", $article->title);
            $this->tag->setDefault("content", $article->content);
            $this->tag->setDefault("tags", $article->tags);
            $this->tag->setDefault("created_at", $article->created_at);
            $this->tag->setDefault("updated_at", $article->updated_at);
            $this->tag->setDefault("pic", $article->pic);
            
        }
    }

    /**
     * Creates a new article
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "index"
            ));
        }

        $article = new Article();

        $article->cate_id = $this->request->getPost("cate_id");
        $article->user_id = $this->request->getPost("user_id");
        $article->title = $this->request->getPost("title");
        $article->content = $this->request->getPost("content");
        $article->tags = $this->request->getPost("tags");
        $article->created_at = $this->request->getPost("created_at");
        $article->updated_at = $this->request->getPost("updated_at");
        $article->pic = $this->request->getPost("pic");
        

        if (!$article->save()) {
            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "new"
            ));
        }

        $this->flash->success("article was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "article",
            "action" => "index"
        ));

    }

    /**
     * Saves a article edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $article = Article::findFirstByid($id);
        if (!$article) {
            $this->flash->error("article does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "index"
            ));
        }

        $article->cate_id = $this->request->getPost("cate_id");
        $article->user_id = $this->request->getPost("user_id");
        $article->title = $this->request->getPost("title");
        $article->content = $this->request->getPost("content");
        $article->tags = $this->request->getPost("tags");
        $article->created_at = $this->request->getPost("created_at");
        $article->updated_at = $this->request->getPost("updated_at");
        $article->pic = $this->request->getPost("pic");
        

        if (!$article->save()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "edit",
                "params" => array($article->id)
            ));
        }

        $this->flash->success("article was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "article",
            "action" => "index"
        ));

    }

    /**
     * Deletes a article
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $article = Article::findFirstByid($id);
        if (!$article) {
            $this->flash->error("article was not found");

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "index"
            ));
        }

        if (!$article->delete()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "article",
                "action" => "search"
            ));
        }

        $this->flash->success("article was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "article",
            "action" => "index"
        ));
    }


}
