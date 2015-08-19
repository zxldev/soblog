<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

/**
 * @RoutePrefix("/api")
 * Class IndexController
 */
class ApiController extends JsonControllerBase
{

    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * @Route("/page={numberpage}/blog", methods={"GET"}, name="blogget")
     * @param int $numberPage
     * @return stdclass
     */
    public function bloggetAction($numberpage = 1)
    {
        $parameters = array();
        $parameters["order"] = "created_at";
        $article = Article::find($parameters);
        $paginator = new Paginator(array(
            "data" => $article,
            "limit"=> 10,
            "page" => $numberpage
        ));
        return $paginator->getPaginate();
    }

    /**
     * @Route("/id={id}/blog", methods={"GET"}, name="bloggetinfo")
     * @param int $id
     * @return stdclass
     */
    public function bloggetinfoAction($id = 1)
    {
        return  Article::findFirstById($id);
    }
}
