<?php
namespace App\Repository;

use App\Models\Queue;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session ;
use Illuminate\Support\Str ;

class DatabaseQueue implements QueueRepository
{
    protected $name='queue';
    public function all(){
        return Queue::where('user_id',auth()->id())->orWhere('cookie_id',$this->getCookieId())->get();
    }
    public function store($request){

        $queue=Queue::create($request->all());
        $queue->cookie_id=$this->getCookieId();
        $queue->user_id=auth()->id();
        $queue->save();
    }
    public function clear(){
        return Queue::where('cookie_id',$this->getCookieId())->orWhere('user_id',auth()->id())->delete();
    }

    public function getCookieId(){
        $id=Cookie::get('queue_cookie_id');
        if(!$id){
            $id=Str::uuid();
            Cookie::queue('queue_cookie_id',$id,60*24);
        }
        return $id;
    }

    public function myQueue($ser){
        return $this->all()->where('service_id',$ser)->whereNull('called_at')->first();
    }
    public function isQueue($ser){
        return $this->all()->where('service_id',$ser)->whereNull('called_at')->count()>0;
    }


}