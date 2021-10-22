<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-around mb-10 ">
                <a href="{{route('ticket.index',['state'=>"waiting"])}}" class=" {{ request()->query('state') == 'waiting' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Waiting</a>
                <a href="{{route('ticket.index',['state'=>"summon"])}}" class=" {{ request()->query('state') == 'summon' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Summon</a>
                <a href="{{route('ticket.index',['state'=>"serving"])}}" class=" {{ request()->query('state') == 'serving' ? 'bg-blue-500 text-white shadow' : 'bg-white text-blue-600' }} p-3 ">Serving</a>
            </div>
            <div class="grid grid-flow-col grid-cols-3 grid-rows-3 gap-4">
                @foreach ($tickets as $tic)
                    <div class="bg-white text-blue-600 p-3 flex items-center justify-between">
                        <h4>Ticket N.{{$tic->id}}</h4>
                        @if (request()->query('state') == 'waiting')
                            <form action="{{route('ticket.changeState')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$tic->id}}">
                                <input type="hidden" name="state" value="summon">
                                <input type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1" value="Call">
                            </form>
                        @endif
                        @if (request()->query('state') == 'summon')
                            <form action="{{route('ticket.changeState')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$tic->id}}">
                                <input type="hidden" name="state" value="serving">
                                <input type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1" value="serving">
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>


        </div>
    </div>
</x-app-layout>
