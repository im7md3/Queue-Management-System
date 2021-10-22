<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueuesController;
use App\Models\Service;
use App\Repository\QueueRepository;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (QueueRepository $queue) {
    $services=Service::withCount(['queues','queues as queues_count' => function ($query) {
        $query->whereNull('called_at');
    }])->get();
    return view('dashboard',compact('services'));
})->name('dashboard');

require __DIR__.'/auth.php';
Route::post('ticket',[QueuesController::class,'store'])->name('ticket.store');
Route::get('{service}/ticket',[QueuesController::class,'index'])->name('ticket.index');
Route::post('queue-call',[QueuesController::class,'queueCall'])->name('queue.call');
Route::post('queue-serve',[QueuesController::class,'queueServe'])->name('queue.serve');
Route::post('sss-serve',[QueuesController::class,'sss'])->name('queue.sss');