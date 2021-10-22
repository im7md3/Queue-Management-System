<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Queue;
use App\Repository\QueueRepository;
use Illuminate\Http\Request;
use Ramsey\Collection\QueueInterface;

class QueuesController extends Controller
{
    protected $myQueue;

    public function __construct(QueueRepository $myQueue){
        $this->myQueue=$myQueue;
    }

    public function store(Request $request){
        $this->myQueue->store($request);

        /* Queue::create($request->all()); */
        return redirect()->back()->with('success','Queue has been booked successfully');
    }
    public function index($ser,Request $request){
        $state=$request->query('state');
        $ser=Service::with(['queues'=>function($query) use($state){
            if($state=='waiting'){
                $query->whereNull('called_at');
            }elseif($state=='summon'){
                $query->whereNull('served_at')->WhereNotNull('called_at');
            }else{
                $query->WhereNotNull('served_at')->WhereNotNull('called_at');
            }
        }])->findOrFail($ser);
        return view('queues.index',compact('ser'));
    }
    public function queueCall(Request $request){
        $ser=Service::findOrFail($request->ser_id);
        $Queue=Queue::findOrFail($request->id);
        $ser->current_queue_id=$Queue->number;
        $Queue->called_at=now();
        $ser->save();
        $Queue->save();
        return redirect()->back()->with('success','Queue has been updated successfully');
    }
    public function queueServe(Request $request){
        $ser=Service::findOrFail($request->ser_id);
        $Queue=Queue::findOrFail($request->id);
        $ser->current_queue_id=null;
        $Queue->served_at=now();
        $Queue->user_id=auth()->id();
        $ser->save();
        $Queue->save();
        return redirect()->back()->with('success','Queue has been updated successfully');
    }

    public function sss(Request $request){

        $Queue=Queue::findOrFail($request->id);

        return intval($Queue->served_at);
    }

}
