<?php
namespace Souii\Models;
class Tags extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $number;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public  static function getAll(){
       $tags = Tags::find()->toArray();
        $ret = [];
        foreach($tags as $tag){
            $ret[$tag['id']]= array(
                'name'=>$tag['name'],
                'number'=>$tag['number']
            );
        }
        return $ret;
    }

    public  static function getAllNameMap(){
        $tags = Tags::find()->toArray();
        $ret = [];
        foreach($tags as $tag){
            $ret[$tag['name']]= array(
                'id'=>$tag['id'],
                'number'=>$tag['number']
            );
        }
        return $ret;
    }

    /**
     * 由名称获取id
     * @param $cacheUtil \Souii\Redis\RedisUtils 清除原有的缓存时需要注入的cacheutil
     * @param $Names string 名称字符串
     * @return string id字符串
     */
    public static function getIDs($Names,$cacheUtil = null,$isUpdate = true,$isInsert = true){
        if($isInsert){
            $cacheUtil->deleteTableCache('TAGS');
        }
        $ret = [];
        $Names = explode(',',$Names);
        foreach($Names as $name){
            $tag = Tags::findFirstByName($name);
            if($tag){
                $ret[] = $tag->id;
                if($isUpdate){
                    $tag->number = $tag->number+1;
                    $tag->save();
                }
            }else{
                if($isInsert){
                    $tag = new Tags();
                    $tag->name = $name;
                    $tag->number = 1;
                    $tag->create();
                    $ret[] = $tag->id;
                }
            }
        }
        return implode(',',$ret);
    }
}
