<?php
/**
 * Created by PhpStorm.
 * User: Caoyang
 * Date: 2018/5/9
 * Time: 11:30
 */

namespace Leslie;

class Pq
{
    public $size;
    public $used;
    public $heap = [];

    public function make_pq($size)
    {
        $this->size = $size;
        $this->used = 0;
        $this->heap = new \SplFixedArray($size);
        return $this;
    }
}
