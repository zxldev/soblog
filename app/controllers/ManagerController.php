<?php
namespace Souii\Controllers;
use Souii\Models\Article as Article;
use Souii\Models\Tags as Tags;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Souii\Redis\RedisUtils as RedisUtils;

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
     * @privateResource(allowYlx="1")
     * Index action
     */
    public function indexAction()
    {
    }

    /**
     * @privateResource(allowYlx="1")
     * Searches for article
     */
    public function searchAction($numberPage = 1)
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Souii\Models\Article", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "created_at desc";

        $article = Article::find($parameters);
        if (count($article) == 0) {
            $this->flash->notice("The search did not find any article");

            return $this->dispatcher->forward(array(
                "controller" => "manager",
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
     * @privateResource(allowYlx="1")
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * @privateResource(allowYlx="1")
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
                    "controller" => "manager",
                    "action" => "index"
                ));
            }

            $this->view->id = $article->id;

            $this->tag->setDefault("id", $article->id);
            $this->tag->setDefault("cate_id", $article->cate_id);
            $this->tag->setDefault("title", $article->title);
            $this->tag->setDefault("content", $article->content);
            $namesArr = $this->redisUtils->getCache(RedisUtils::$CACHEKEYS['TAGS']['ALL'],'Souii\Models\TAGS::getAll','ALL');
            $names = [];
            foreach(explode(',',$article->tags) as $id){
                if(!empty($id)){
                    $names[] = $namesArr[$id]['name'];
                }
            }
            $this->tag->setDefault("tags", implode(',',$names));
            $this->tag->setDefault("pic", $article->pic);
            
        }
    }

    /**
     * @privateResource(allowYlx="1")
     * Creates a new article
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "index"
            ));
        }

        $article = new Article();

        $article->cate_id = $this->request->getPost("cate_id");
        $article->user_id = $this->getSession('user')['id'];
        $article->title = $this->request->getPost("title");
        $article->content = $this->request->getPost("content");
        $article->tags = $this->request->getPost("tags");
        $article->created_at = date('Y-m-d H:i:s',time());
        $article->updated_at = date('Y-m-d H:i:s',time());
        $article->pic = $this->request->getPost("pic");
        

        if (!$article->save()) {
            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "new"
            ));
        }
        $this->redisUtils->deleteTableCache('article');
        $this->flash->success("article was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "manager",
            "action" => "index"
        ));

    }

    /**
     * @privateResource(allowYlx="1")
     * Saves a article edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $article = Article::findFirstByid($id);
        if (!$article) {
            $this->flash->error("article does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "index"
            ));
        }

        $article->cate_id = $this->request->getPost("cate_id");
        $article->user_id = $this->getSession('user')['id'];
        $article->title = $this->request->getPost("title");
        $article->content = $this->request->getPost("content");
        $article->tags = Tags::getIDs($this->redisUtils,$this->request->getPost("tags")) ;
        $article->updated_at = date('Y-m-d H:i:s',time());
        $article->pic = $this->request->getPost("pic");
        

        if (!$article->save()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "edit",
                "params" => array($article->id)
            ));
        }
        $this->redisUtils->deleteTableCache('article');
        $this->flash->success("article was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "manager",
            "action" => "index"
        ));

    }

    /**
     * @privateResource(allowYlx="1")
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
                "controller" => "manager",
                "action" => "index"
            ));
        }

        if (!$article->delete()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "manager",
                "action" => "search"
            ));
        }
        $this->redisUtils->deleteTableCache('article');
        $this->flash->success("article was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "manager",
            "action" => "index"
        ));
    }


}
