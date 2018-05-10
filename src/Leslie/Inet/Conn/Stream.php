<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/5
 * Time: 10:30
 */

namespace Leslie\Inet\Conn;

use Leslie\Inet\Connection;

class Stream extends Conn
{
    /**
     * 监听套接字对象
     * @var object
     */
    protected $socket;


    public function __construct(Connection $conn)
    {
        $this->socket = null;
        $this->conn_config_object = $conn;
    }

    /**
     * 创建监听套接字对象
     * @return $this
     */
    public function make_object()
    {
        $local_socket = 'tcp://' . $this->conn_config_object->host . ':' . $this->conn_config_object->port;
        $this->socket = stream_socket_server($local_socket, $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN);

        return $this;
    }

    /**
     * 设置监听套接字属性
     */
    public function setOptions()
    {
        $server_socket = socket_import_stream($this->socket);
        socket_set_option($server_socket, SOL_TCP, TCP_NODELAY, 1);
        socket_set_option($server_socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_set_option($server_socket, SOL_SOCKET, SO_KEEPALIVE, 1);
        socket_set_option($server_socket, SOL_SOCKET, SO_LINGER, ['l_linger' => 0, 'l_onoff' => 0]);
        stream_set_blocking($this->socket, 0);
    }

    /**
     * 获取操作的流对象
     *
     * @return null
     */
    public function getSocket()
    {
        return $this->socket;
    }
}
