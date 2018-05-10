<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/9
 * Time: 11:13
 */

namespace Leslie\Service\Task;

use Leslie\Cmd\CBase;
use Leslie\Cmd\Status;
use Leslie\Event\Base;
use Leslie\Inet\Connection;
use Leslie\Prot;

class Queue
{
    /**
     * 事件流对象
     * @var null|void
     */
    protected $stream;


    public function __construct()
    {
        $conn = new Connection('0.0.0.0', 2489);
        $this->stream = $conn->make_connection('Stream');
        $conn->setOptions();
        $prot = new Prot();
        $prot->prot_init();
    }

    /**
     * 开启服务
     */
    public function startup()
    {
        pcntl_signal(SIGPIPE, SIG_IGN);
        $event = new Base('libevent', $this->stream->getSocket());
        $event->on('connection', function ($stream) {
            echo 'connection', PHP_EOL;
        });

        $event->on('receive', function ($stream, $data) {
            // {"cmd": "status", "data": ""}
            $cmd_status = new Status();
            $cmd_object = new CBase($cmd_status);
            $cmd_object->execute();
        });

        $event->on('close', function ($stream) {
            echo 'close', PHP_EOL;
        });

        $event->dispatch(EV_READ | EV_PERSIST, $event->get_fd(), $event);
        $event->loop();
    }
}
