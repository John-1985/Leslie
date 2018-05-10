<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/9
 * Time: 11:34
 */

namespace Leslie;

class Prot
{
    const HEAD_SIZE = 16;

    protected $ready_q;


    public function prot_init()
    {
        $pq = new Pq();
        $this->ready_q = $pq->make_pq(self::HEAD_SIZE);
    }
}
