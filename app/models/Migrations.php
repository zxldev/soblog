<?php
namespace Souii\Models;
class Migrations extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $migration;

    /**
     *
     * @var integer
     */
    public $batch;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'migrations';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Migrations[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Migrations
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
