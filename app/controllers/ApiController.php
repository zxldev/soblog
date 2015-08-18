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
     * @Route("/blog/{numberPage}", methods={"GET"}, name="blogget")
     * @param int $numberPage
     * @return stdclass
     */
    public function blogAction($numberPage = 1)
    {
        $parameters = array();
        $parameters["order"] = "created_at";
        $article = Article::find($parameters);
        $paginator = new Paginator(array(
            "data" => $article,
            "limit"=> 10,
            "page" => $numberPage
        ));

        return $paginator->getPaginate();
    }
}
