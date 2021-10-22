<?php
namespace App\Repository;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session ;

class CookieQueue implements QueueRepository
{
    protected $name='queue';
    public function all(){
        $queues=Cookie::get($this->name);
        if($queues){
            return unserialize($queues);
        }
        return Cookie::get($this->name);
    }
    public function store($queue){
        $queues=$this->all();
        $queues[]=$queue;
        Cookie::queue($this->name,serialize($queues),60 * 24);
    }
    public function clear(){
        Cookie::queue($this->name,'',-60);
    }
}