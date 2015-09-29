<?php
namespace Souii\Controllers;
use Souii\Models;
/**
 * Created by PhpStorm.
 * User: xiaolong
 * Date: 2015/6/19
 * Time: 14:57
 */
interface ISessionInterface{

    /**
     * @param $key
     * @param $arraykey
     * @param string $default
     * @return mixed
     */
    public function  getSessionValue($key, $arraykey,$default = '');

    public function getSession($key, $default = '');

    public function getSessionId();

    public function setSession($key,$value);

    public function destorySession();

}