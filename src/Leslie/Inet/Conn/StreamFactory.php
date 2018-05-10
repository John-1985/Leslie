<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/5
 * Time: 10:37
 */

namespace Leslie\Inet\Conn;


use Leslie\Inet\Connection;

class StreamFactory implements IFactory
{
    protected $conn_config;


    public function __construct(Connection $conn)
    {
        $this->conn_config = $conn;
    }

    /**
     * 获取流对象
     *
     * @return Stream
     */
    public function get()
    {
        return new Stream($this->conn_config);
    }
}
