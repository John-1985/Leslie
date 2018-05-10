<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/9
 * Time: 11:26
 */

namespace Leslie;

class Job
{
    public $prev;
    public $next;
    public $id;
    public $pri;
    public $body_size;
    public $creation;
    public $deadtion;
    public $timeout_ct;
    public $state;
    public $body;
}
