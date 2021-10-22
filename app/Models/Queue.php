<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $fillable=['cookie_id','user_id','service_id','number','called_at','served_at','served_user_id'];
    public function service(){
        return $this->belongsTo(Service::class);
    }

    

    protected static function booted()
    {

        static::creating(function (Queue $queue) {
            $max=Queue::where('service_id',$queue->service_id)->max('number');
            $queue->number=$max+1;
        });
    }
}
