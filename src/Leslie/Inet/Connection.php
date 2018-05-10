<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/5
 * Time: 10:23
 */

namespace Leslie\Inet;


use Leslie\Inet\Conn\StreamFactory;

class Connection
{
    /**
     * 监听地址
     * @var string
     */
    public $host;

    /**
     * 监听端口
     * @var int
     */
    public $port;

    /**
     * 链接对象
     * @var null
     */
    public $conn;

    /**
     * 链接工厂对象
     * @var object
     */
    protected $conn_factory;


    public function __construct($host, $port)
    {
        if (false === is_numeric($port)) {
            throw new \InvalidArgumentException('端口值类型只能为数字');
        }

        $this->host = $host;
        $this->port = $port;
        $this->conn = null;
    }

    /**
     * 获取连接对象
     *
     * @return null
     */
    public function get_conn()
    {
        return $this->conn;
    }

    /**
     * 获取连接对象工厂
     *
     * @return mixed
     */
    public function get_conn_factory()
    {
        return $this->conn_factory;
    }

    /**
     * 设置连接对象工厂
     *
     * @param $type
     * @return StreamFactory
     */
    protected function set_conn_factory($type)
    {
        switch ($type) {
            case 'Stream':
                $this->conn_factory = new StreamFactory($this);
                break;
            default:
                break;
        }

        return $this->conn_factory;
    }

    /**
     * 造连接对象
     *
     * @param $type_name
     * @return null|void
     */
    public function make_connection($type_name)
    {
        $this->conn = $this->set_conn_factory($type_name)->get()->make_object();
        return $this->conn;
    }

    /**
     * 设置连接属性
     */
    public function setOptions()
    {
        $this->get_conn()->setOptions();
    }
}
