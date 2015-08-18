<?php

class Systems extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $cate;

    /**
     *
     * @var string
     */
    public $system_name;

    /**
     *
     * @var string
     */
    public $system_value;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'systems';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Systems[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Systems
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
