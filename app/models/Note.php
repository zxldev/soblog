<?php

namespace Souii\Models;

class Note extends \Phalcon\Mvc\Model
{
    public static $typemap = array(
        'getup'=> 'daily',
        'exercise' =>'daily',
        'sleep' =>'daily',
        'reading'=>'study',
        'coding'=>'study',
    );

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var integer
     */
    public $state;

    /**
     *
     * @var string
     */
    public $type;


    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'note';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Note[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Note
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function replayEventKey($EventKey){
        if(substr($EventKey,0,5)=='query'){
            return self::queryNote($EventKey);
        }else{
            return self::newEventNote($EventKey);
        }
    }

    public static function newEventNote($EventKey){
        $note = new Note();
        $note->type = self::$typemap[$EventKey];
        $note->content =$EventKey;
        $note->created_at = date('Y-m-d H:i:s');
        $note->state = 1;
        $ret = $note->save();
        return  "Note$EventKey 保存:$ret";
    }

    public static function queryNote($type){
        $type = substr($type,5);
        $notes = self::find(array(
            "type = '$type'",
            "order"=>'created_at desc',
            "limit"=>10,
        ));
        $ret = '';
        foreach($notes as $note){
            $ret .= '['.$note->id."]\t:\t[".$note->created_at."]\n".$note->content."\n\n";
        }
        return $ret;
    }


}
