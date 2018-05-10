<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/8
 * Time: 17:02
 */

require_once __DIR__ . '/vendor/autoload.php';

$queue_service = new \Leslie\Service\Task\Queue();
$queue_service->startup();
