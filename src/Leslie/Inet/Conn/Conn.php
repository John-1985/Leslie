<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/5
 * Time: 10:52
 */

namespace Leslie\Inet\Conn;

abstract class Conn
{
    public $conn_config_object;

    public abstract function make_object();

    public abstract function setOptions();
}
