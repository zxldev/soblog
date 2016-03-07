<?php
namespace Souii\Redis;
/**
 * Created by PhpStorm.
 * User: zx
 * Date: 2015/8/26
 * Time: 9:27
 */
use Phalcon\Mvc\User\Component;
class RedisUtils extends Component{

    /**
     * redis的key前缀
     * @var array
     */
    public static $CACHEKEYS = array(
        'ARTICLE' =>array(
            'PAGE:TAG:CATE'=>'h:cache:article:cache',
            'ID'=>'h:cache:article:id',
            'TAG'=>'h:cache:article:tag',
            'CATE'=>'h:cache:article:cate',
        ),
        'SYSTEMS' =>array(
            'KEY'=>'h:cache:systems:key'
        ),
        'CATEGORY' => array(
            'ALL'=>'h:cache:category:all'
        ),
        'TAGS'=>array(
            'ALL'=>'h:cache:tags:all'
        )
    );

    public static $WEIXIN = array(
        'USER' => 'h:weixin:user:',
    );

    /**
     * 获取redis缓存
     * @param $prefix
     * @param $callback
     * @return mixed
     */
    public  function getCache($prefix,$callback){
        /**
         * 获取函数参数值
         */
        $param = func_get_args();
        /**
         * 先获取关键参数$prefix和callback，在获取动态参数
         */
        $prefix = array_shift($param);
        $callback = array_shift($param);
        $key = implode(':',$param);
        //尝试从redis获取参数，如果不存在，调用自定义callback函数获取
        $ret = json_decode($this->redis->hGet($prefix,$key),true);
        if(!$ret){
            $ret = call_user_func_array($callback,$param);
            $this->redis->hset($prefix,$key,json_encode($ret));
        }
        return  $ret;
    }

    /**
     * 清理一张表的缓存
     * @param $tableName
     */
    public function deleteTableCache($tableName){
        $tableName = strtoupper($tableName);
        if(isset(RedisUtils::$CACHEKEYS[$tableName])){
            foreach(RedisUtils::$CACHEKEYS[$tableName] as $key=>$value){
                $this->redis->del($value);
            }
        }
    }
}