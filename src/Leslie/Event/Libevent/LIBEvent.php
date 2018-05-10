<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/5
 * Time: 11:08
 */

namespace Leslie\Event\Libevent;

use Leslie\Event\IEvent;

class LIBEvent implements IEvent
{
    /**
     * 基础事件对象
     * @var bool|resource
     */
    protected $base_event;

    /**
     * 套接字对象
     * @var object
     */
    protected $fd_socket;

    /**
     * 事件集
     * @var array
     */
    protected static $event_sets = [];


    public function __construct($socket)
    {
        if (false === extension_loaded('Libevent')) {
            throw new \RuntimeException('Libevent 扩展没有加载');
        }

        $this->base_event = event_base_new();
        $this->fd_socket = $socket;
    }

    /**
     * 获取套接字
     * @return mixed
     */
    public function get_fd()
    {
        return $this->fd_socket;
    }

    /**
     * 设置事件处理器
     * @param $event_name
     * @param $fd
     * @param callable $cb_func
     */
    public function set_event($event_name, $fd, callable $cb_func)
    {
        $new_event = event_new();
        self::$event_sets[] = $new_event;

        event_set($new_event, $fd, $event_name, function ($stream, $events, $arg) use ($cb_func) {
            call_user_func($cb_func, $stream, $events, $arg);
        }, [$new_event, $this->base_event]);

        event_base_set($new_event, $this->base_event);

        event_add($new_event);
    }

    /**
     * 销毁事件对象
     */
    public function destroy()
    {
        foreach (self::$event_sets as $event) {
            event_del($event);
        }
    }

    /**
     * 处理事件
     */
    public function loop()
    {
        event_base_loop($this->base_event);
    }
}
