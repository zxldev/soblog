<?php
namespace Souii\Controllers;
use Phalcon\Http\Response;
use Phalcon\Mvc\View;
use Phalcon\Text;
use Souii\Models;
use Souii\Site\NetWorkUtils;
use Souii\WeiXinQiYe;

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('首页');
        parent::initialize();
        $this->view->setTemplateAfter('header');
    }

    /**
     * @Route("/page={page}/tag={tag}/cate={cate}", methods={"GET"}, name="index")
     * @param string $tag
     */
    public function indexAction($page = 1,$tag = '',$cate='')
    {

        //爬虫特殊处理
        if(NetWorkUtils::isSpider()){
            $data = ApiController::blogget($page);
            $totalpage = $data->total_pages;
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
            if($page<$totalpage){
                $html.=' <ul class="pager">
                        <li class="next">
                        <a href="'.$this->config->site['url'].'/page='.($page+1).'/tag=">更多 &rarr;</a>
                        </li>
                        </ul>';
            }

            echo $html;
        }

        $this->tag->setDefault("tag", $tag);
        $this->tag->setDefault("cate", $cate);
        $this->view->tag = $tag;
        if($cate!=''){
            $this->view->cateEntity = Models\Category::findFirst($cate);
        }
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

    /**
     * 微信校验接口
     * @Route("/api/qiyecallback", methods={"GET"}, name="qiyecallback")
     */
    public function WeiXinQiYeApiAction(){
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);

// 假设企业号在公众平台上设置的参数如下
        $encodingAesKey = $this->config->thirdpart->weixinqiye['encodingAesKey'];
        $token = $this->config->thirdpart->weixinqiye['token'];
        $corpId = $this->config->thirdpart->weixinqiye['corpId'];

        /*
        ------------使用示例一：验证回调URL---------------
        *企业开启回调模式时，企业号会向验证url发送一个get请求
        假设点击验证时，企业收到类似请求：
        * GET /cgi-bin/wxpush?msg_signature=5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3&timestamp=1409659589&nonce=263014780&echostr=P9nAzCzyDtyTWESHep1vC5X9xho%2FqYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp%2B4RPcs8TgAE7OaBO%2BFZXvnaqQ%3D%3D
        * HTTP/1.1 Host: qy.weixin.qq.com

        接收到该请求时，企业应
        1.解析出Get请求的参数，包括消息体签名(msg_signature)，时间戳(timestamp)，随机数字串(nonce)以及公众平台推送过来的随机加密字符串(echostr),
        这一步注意作URL解码。
        2.验证消息体签名的正确性
        3. 解密出echostr原文，将原文当作Get请求的response，返回给公众平台
        第2，3步可以用公众平台提供的库函数VerifyURL来实现。

        */

// $sVerifyMsgSig = HttpUtils.ParseUrl("msg_signature");
        $sVerifyMsgSig = $this->request->get('msg_signature');
// $sVerifyTimeStamp = HttpUtils.ParseUrl("timestamp");
        $sVerifyTimeStamp = $this->request->get('timestamp');
// $sVerifyNonce = HttpUtils.ParseUrl("nonce");
        $sVerifyNonce = $this->request->get('nonce');
// $sVerifyEchoStr = HttpUtils.ParseUrl("echostr");
        $sVerifyEchoStr =$this->request->get('echostr');

// 需要返回的明文
        $EchoStr = "";

        $wxcpt = new \Souii\WeiXinQiYe\WXBizMsgCrypt($token, $encodingAesKey, $corpId);
        $sEchoStr = "";
        $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
//        if ($errCode == 0) {
            $this->response->setContent($sEchoStr);
            $this->response->setStatusCode("200");
//        } else {
//            $this->response->setContent("1");
//            $this->response->setStatusCode("200");
//        }
    }

    /**
     * @Route("/api/qiyecallback", methods={"POST"}, name="reciveMsg")
     */
    public function reciveMsgAction(){
        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        $encodingAesKey = $this->config->thirdpart->weixinqiye['encodingAesKey'];
        $token = $this->config->thirdpart->weixinqiye['token'];
        $corpId = $this->config->thirdpart->weixinqiye['corpId'];
        $wxcpt = new \Souii\WeiXinQiYe\WXBizMsgCrypt($token, $encodingAesKey, $corpId);

// $sReqMsgSig = HttpUtils.ParseUrl("msg_signature");
        $sReqMsgSig =$this->request->get('msg_signature');
// $sReqTimeStamp = HttpUtils.ParseUrl("timestamp");
        $sReqTimeStamp = $this->request->get('timestamp');
// $sReqNonce = HttpUtils.ParseUrl("nonce");
        $sReqNonce = $this->request->get('nonce');


// post请求的密文数据
// $sReqData = HttpUtils.PostData();
        $sReqData = $this->request->getRawBody();// "<xml><ToUserName><![CDATA[wx5823bf96d3bd56c7]]></ToUserName><Encrypt><![CDATA[RypEvHKD8QQKFhvQ6QleEB4J58tiPdvo+rtK1I9qca6aM/wvqnLSV5zEPeusUiX5L5X/0lWfrf0QADHHhGd3QczcdCUpj911L3vg3W/sYYvuJTs3TUUkSUXxaccAS0qhxchrRYt66wiSpGLYL42aM6A8dTT+6k4aSknmPj48kzJs8qLjvd4Xgpue06DOdnLxAUHzM6+kDZ+HMZfJYuR+LtwGc2hgf5gsijff0ekUNXZiqATP7PF5mZxZ3Izoun1s4zG4LUMnvw2r+KqCKIw+3IQH03v+BCA9nMELNqbSf6tiWSrXJB3LAVGUcallcrw8V2t9EL4EhzJWrQUax5wLVMNS0+rUPA3k22Ncx4XXZS9o0MBH27Bo6BpNelZpS+/uh9KsNlY6bHCmJU9p8g7m3fVKn28H3KDYA5Pl/T8Z1ptDAVe0lXdQ2YoyyH2uyPIGHBZZIs2pDBS8R07+qN+E7Q==]]></Encrypt><AgentID><![CDATA[218]]></AgentID></xml>";
        $sMsg = "";  // 解析之后的明文
        $errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        if ($errCode == 0||empty($errCode)) {
            // 解密成功，sMsg即为xml格式的明文
            // TODO: 对明文的处理
            // For example:
            $xml = new \DOMDocument();
            $xml->loadXML($sMsg);
            $content = $xml->getElementsByTagName('Content')->item(0)->nodeValue;
            $MsgType = $xml->getElementsByTagName('MsgType')->item(0)->nodeValue;
            $FromUserName = $xml->getElementsByTagName('FromUserName')->item(0)->nodeValue;
            $ToUserName = $xml->getElementsByTagName('ToUserName')->item(0)->nodeValue;
            $AgentID = $xml->getElementsByTagName('AgentID')->item(0)->nodeValue;
            $timestemp = time();
            $sRespData = "<xml><ToUserName><![CDATA[$FromUserName]]></ToUserName><FromUserName><![CDATA[$ToUserName]]></FromUserName><CreateTime>$timestemp</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[$content]]></Content></xml>";
            $sEncryptMsg = ""; //xml格式的密文
            $this->logger->log("X===========".json_encode(array($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg)), \Phalcon\Logger::INFO);
            $errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
            $this->logger->log("Y===========".json_encode(array($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg)), \Phalcon\Logger::INFO);
//            if ($errCode == 0||empty($errCode)) {
                // TODO:
            echo $sEncryptMsg;
//                $this->response->setContent($sEncryptMsg);
//                $this->response->setStatusCode("200");
                // 加密成功，企业需要将加密之后的sEncryptMsg返回
                // HttpUtils.SetResponce($sEncryptMsg);  //回复加密之后的密文
//            } else {
//                print("ERR: " . $errCode . "\n\n");
//                // exit(-1);
//            }
        } else {
            print("ERR: " . $errCode . "\n\n");
            //exit(-1);
        }
    }
}
