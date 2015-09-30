<?php
namespace Souii\Controllers;
use Souii\Models;
use Souii\Site\NetWorkUtils;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('欢迎');
        parent::initialize();
        $this->view->setTemplateAfter('header');
    }

    /**
     * @Route("/tag={tag}", methods={"GET"}, name="index")
     * @param string $tag
     */
    public function indexAction($tag = '')
    {
        $this->tag->setDefault("tag", $tag);
        //爬虫特殊处理
        if(NetWorkUtils::isSpider()){
            $data = ApiController::blogget(0);
            $items = $data->items;
             $i = 0;
                $html = '';
               $length = $data->total_items;
                $tags = '';
            for ($i = 0; $i < $length; $i++) {
                $html .= '<div class="post-preview"><a href="/article/info/' .
                    $items[$i]['id'] . '"><h2 class="post-title">' .
                $items[$i]['title'] . '</h2></a><h4  class="post-subtitle">';

                    $tags =  explode(',',$items[$i]['tags']);
                foreach($tags as $tag){
                    $html .= '<span  class="">' . $tag . '</span> ';
                }

                $html .= '</h4><p class="post-meta">发布于' . $items[$i]['updated_at'] . '</p></div><hr>';
            }
            echo $html;
        }
        $this->view->tag = $tag;
    }
}
