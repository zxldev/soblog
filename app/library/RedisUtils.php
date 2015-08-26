<?php
/**
 * Created by PhpStorm.
 * User: zx
 * Date: 2015/8/26
 * Time: 9:27
 */
use Phalcon\Mvc\User\Component;
class RedisUtils extends Component{

    public static $CACHEKEYS = array(
        'ARTICLE' =>array(
            'PAGE'=>'h:cache:article:cache'
        ),
        'SYSTEMS' =>array(
            'KEY'=>'h:cache:systems:key'
        )
    );

    /**
     * @param $prefix
     * @param $callback
     * @return mixed
     */
    public  function getCache($prefix,$callback){
        $param = func_get_args();
        $prefix = array_shift($param);
        $callback = array_shift($param);
        $key = implode(':',$param);
        $ret = json_decode($this->redis->hGet($prefix,$key));
        if(!$ret){
            $ret = call_user_func_array($callback,$param);
            $this->redis->hset($prefix,$key,json_encode($ret));
        }
        return  $ret;
    }

    public function deleteTableCache($tableName){
        $tableName = strtoupper($tableName);

        if(isset(RedisUtils::$CACHEKEYS[$tableName])){
            foreach(RedisUtils::$CACHEKEYS[$tableName] as $key=>$value){
                $this->redis->del($value);
            }
        }
    }
}