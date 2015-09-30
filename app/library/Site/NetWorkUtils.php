<?php
/**
 * Created by PhpStorm.
 * User: zx
 * Date: 2015/9/30
 * Time: 9:34
 */
namespace Souii\Site;
use Phalcon\Mvc\User\Component;
class NetWorkUtils extends Component{
    public  static function isSpider(){
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(!empty($ua)){
            $spiderAgentArr = array(
                "Baiduspider",
                "Googlebot",
                "360Spider",
                "Sosospider",
                "sogou spider"
            );
            foreach($spiderAgentArr as $val){
                $spiderAgent = strtolower($val);
                if(strpos($ua, $spiderAgent) !== false){
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }
}