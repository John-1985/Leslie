<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/9
 * Time: 17:57
 */

namespace Leslie\Cmd;

class CBase
{
    protected $cmd_object;


    public function __construct($object)
    {
        $this->cmd_object = $object;
    }

    public function execute()
    {
        $this->cmd_object->execute();
    }
}
