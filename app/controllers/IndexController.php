<?php
namespace Souii\Controllers;
use Souii\Models;
use Souii\Site\NetWorkUtils;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('首页');
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
               $length = count($data->items);
                $tags = '';
            for ($i = 0; $i < $length; $i++) {
                $html .= '<div class="post-preview"><a href="'.$this->config->site['url'].'/article/info/' .
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

    public function uploadAction(){
        $root = $this->config->database->username;
        $pass = $this->config->database->password;
        $dbname = $this->config->database->dbname;
        $timestr = date('YmdHis');
        $fileName = "backupMysqlFile-$timestr.sql.gz";
        $filePath = "/backup/mysql/$fileName";
        $command = "mysqldump -h127.0.0.1 -u$root -p$pass $dbname | gzip > $filePath";
        exec($command);
        $ret = $this->qiniuuploadMgr->putFile($this->qiniuToken,$fileName,$filePath);
    }
}
