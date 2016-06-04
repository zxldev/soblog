<?php
namespace Souii\Models;
class Category extends \Phalcon\Mvc\Model
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
    public $cate_name;

    /**
     *
     * @var string
     */
    public $as_name;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var string
     */
    public $seo_title;

    /**
     *
     * @var string
     */
    public $seo_key;

    /**
     *
     * @var string
     */
    public $seo_desc;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $class_name;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function  getAll(){
        $tags = Category::find()->toArray();
        $ret = [];
        foreach($tags as $tag){
            $ret[$tag['id']]= array(
                'cate_name'=>$tag['cate_name'],
                'class_name'=>$tag['class_name']
            );
        }
        return $ret;
    }
    public static function  getAllStaticSelect(){
        $tags = Category::find()->toArray();
        $ret = [];
        foreach($tags as $tag){
            $ret[$tag['id']]= $tag['cate_name'];
        }
        return $ret;
    }

}
