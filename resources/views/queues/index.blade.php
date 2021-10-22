<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserved tickets for service: ') }} {{$ser->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-around mb-10 ">
                <a href="{{route('ticket.index',[$ser->id,'state'=>"waiting"])}}" class=" {{ request()->query('state') == 'waiting' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Waiting</a>
                <a href="{{route('ticket.index',[$ser->id,'state'=>"summon"])}}" class=" {{ request()->query('state') == 'summon' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Summon</a>
                <a href="{{route('ticket.index',[$ser->id,'state'=>"serving"])}}" class=" {{ request()->query('state') == 'serving' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Serving</a>
            </div>
            <div class="grid grid-flow-col grid-cols-3 grid-rows-3 gap-4">
                @foreach ($ser->queues as $queue)
                    <div class="bg-white text-blue-600 p-3 flex items-center justify-between shadow">
                        <h4>Ticket N.{{$queue->number}}</h4>
                        @if ($queue->called_at==null)
                            <form action="{{route('queue.call')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$queue->id}}">
                                <input type="hidden" name="ser_id" value="{{$ser->id}}">
                                <button type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1">Call</button>
                            </form>
                        @endif
                        @if ($queue->served_at==null && $queue->called_at!=null)
                            <form action="{{route('queue.serve')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$queue->id}}">
                                <input type="hidden" name="ser_id" value="{{$ser->id}}">
                                <button type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1">Serve</button>
                            </form>
                        @endif


                    </div>
                @endforeach
            </div>


        </div>
    </div>
</x-app-layout>
