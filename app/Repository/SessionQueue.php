<?php
namespace App\Repository;


use Illuminate\Support\Facades\Session ;

class SessionQueue implements QueueRepository
{
    protected $key='queue';
    public function all(){
        Session::get($this->key);
    }
    public function store($queue){
        Session::push($this->key, $queue);
    }
    public function clear(){
        Session::forget($this->key);
    }
}