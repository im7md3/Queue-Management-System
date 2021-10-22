<?php
namespace App\Repository;
interface QueueRepository
{

    public function all();
    public function store($queue);
    public function clear();
}