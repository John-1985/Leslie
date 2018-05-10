<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/8
 * Time: 17:52
 */

namespace Leslie\Event;

interface IEvent
{
    public function get_fd();

    public function set_event($event_name, $fd, callable $cb_func);

    public function loop();
}
