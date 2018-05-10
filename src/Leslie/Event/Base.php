<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/8
 * Time: 17:40
 */

namespace Leslie\Event;

use Leslie\Event\Libevent\LIBEvent;

class Base
{
    /**
     * 支持的事件类型集
     */
    CONST EVENT_DRIVER_TYPE = [
        'select',
        'libevent',
        'ev'
    ];

    /**
     * 事件类型
     * @var string
     */
    protected $driver_type;

    /**
     * 基础事件对象
     * @var object
     */
    protected $base_event;

    /**
     * 事件描述标志
     * @var int
     */
    protected $fd_socket;

    /**
     * 处理特定事件处理类
     * @var LIBEvent
     */
    protected $event_object;

    /**
     * 事件回调对象
     * @var array
     */
    protected $cb_func_event;


    public function __construct($event_driver_type, $socket)
    {
        if (false === is_string($event_driver_type)
            || !in_array($event_driver_type, self::EVENT_DRIVER_TYPE)
        ) {
            throw new \InvalidArgumentException('传入的事件驱动类型暂时不支持');
        }

        $this->driver_type = $event_driver_type;
        $this->fd_socket = $socket;
        switch ($event_driver_type) {
            case 'select':
                break;
            case 'libevent':
                $this->event_object = new LIBEvent($this->fd_socket);
                break;
            case 'ev':
                break;
            default:
                break;
        }
    }

    /**
     * 获取类型驱动事件类型名称
     * @return string
     */
    public function get_driver_type()
    {
        return $this->driver_type;
    }

    /**
     * 获取事件标志
     * @return int
     */
    public function get_fd()
    {
        return $this->fd_socket;
    }

    /**
     * 开启事件处理
     * @param $event_name
     * @param $fd
     */
    final public function dispatch($event_name, $fd)
    {
        $this->event_object->set_event($event_name, $fd, function ($stream) {
            call_user_func($this->cb_func_event['connection'], $stream);
            $server_conn_stream = stream_socket_accept($stream);
            stream_set_blocking($server_conn_stream, 0);
            $this->event_object->set_event(EV_READ | EV_PERSIST, $server_conn_stream, function ($stream) {
                $data = '';
                while ($data_fragment = socket_read(socket_import_stream($stream), 2)) {
                    $data_fragment_len = preg_replace('/[\r\n]/ims', '', $data_fragment);
                    if (strlen($data_fragment_len) === 0 && preg_match_all('/[\r\n]/ims', $data_fragment)) {
                        break;
                    }

                    $data .= $data_fragment;
                }

                if (empty($data_fragment)) {
                    $this->event_object->destroy();
                    call_user_func($this->cb_func_event['close'], $stream);
                }

                call_user_func($this->cb_func_event['receive'], $stream, $data);
            });
        });
    }

    /**
     * 事件回调绑定
     * @param $event_name
     * @param callable $cb_func
     */
    public function on($event_name, callable $cb_func)
    {
        $this->cb_func_event[$event_name] = $cb_func;
    }

    /**
     * 监听事件
     */
    public function loop()
    {
        $this->event_object->loop();
    }
}
