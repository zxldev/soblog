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
     * @Route("/page={numberpage}/tag={tag}/blog", methods={"GET"}, name="blogget")
     * @param int $numberPage
     * @return stdclass
     */
    public function bloggetAction($numberpage = 1,$tag='')
    {
        if($tag!=''){
            return $this->redisUtils->getCache(RedisUtils::$CACHEKEYS['ARTICLE']['TAG'],'ApiController::bloggettag',$numberpage,$tag);
        }else{
            return $this->redisUtils->getCache(RedisUtils::$CACHEKEYS['ARTICLE']['PAGE'],'ApiController::blogget',$numberpage);
        }

    }

    public static function bloggettag($numberpage,$tag){
        $parameters = array();
        $parameters["order"] = "created_at desc";
        $parameters["conditions"] = 'tag like ';
        //TODO 从这里开始
        $parameters['columns'] = array('id,title,tags,updated_at');
        $article = Article::find($parameters);
        $paginator = new Paginator(array(
            "data" => $article,
            "limit"=> 10,
            "page" => $numberpage
        ));
        $page =          $paginator->getPaginate();
        $map = Tags::getAll();

        foreach($page->items as $item){
            $ret = [];
            $tags = explode(',',$item->tags);
            foreach($tags as $tag){
                if(!empty($tag)){
                    $ret[] = $map[$tag]['name'];
                }
            }
            $item->tags = implode(',',$ret);
        }
        return $page;
    }

    public static function blogget($numberpage){
        $parameters = array();
        $parameters["order"] = "created_at desc";
        $parameters['columns'] = array('id,title,tags,updated_at');
        $article = Article::find($parameters);
        $paginator = new Paginator(array(
            "data" => $article,
            "limit"=> 10,
            "page" => $numberpage
        ));
        $page =          $paginator->getPaginate();
        $map = Tags::getAll();

        foreach($page->items as $item){
            $ret = [];
            $tags = explode(',',$item->tags);
            foreach($tags as $tag){
                if(!empty($tag)){
                    $ret[] = $map[$tag]['name'];
                }
            }
            $item->tags = implode(',',$ret);
        }
        return $page;
    }

    /**
     * @Route("/id={id}/blog", methods={"GET"}, name="bloggetinfo")
     * @param int $id
     * @return stdclass
     */
    public function bloggetinfoAction($id = 1)
    {
        return $this->redisUtils->getCache(RedisUtils::$CACHEKEYS['ARTICLE']['ID'],'ApiController::bloggetinfo',$id);
    }

    public static function bloggetinfo($id)
    {
        $atricle = Article::findFirstById($id);
        $map = Tags::getAll();
        $ret = [];
        $tags = explode(',', $atricle->tags);
        foreach ($tags as $tag) {
            if (!empty($tag)) {
                $ret[] = $map[$tag]['name'];
            }
        }
        $atricle->tags = implode(',', $ret);
        return $atricle;
    }

    /**
     * @Route("/weiboLogincallback", methods={"GET"}, name="blogget")
     */
    public function weiboLogincallbackAction()
    {
        $o = $this->weiboOauth;

        if (isset($_REQUEST['code'])) {
            $keys = array();
            $keys['code'] = $_REQUEST['code'];
            $keys['redirect_uri'] = $this->config->thirdpart['weibo']['WB_CALLBACK_URL'];
            try {
                $token = $o->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
            }
        }

        if ($token) {
//            //登陆
//            $_SESSION['token'] = $token;
//            setcookie('weibojs_' . $o->client_id, http_build_query($token));
//            //授权完成,<a href="weibolist.php">进入你的微博列表页面</a><br />
        } else {
            //授权失败。
        }

    }
}
