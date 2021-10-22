<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



            <div class="grid grid-cols-4 gap-4">
                @foreach($services as $ser)
                    <div class="bg-white p-3">
                        <h3>{{ $ser->name }}</h3>
                        <span>{{ $ser->number_waiting }}</span>
                        <p>The number of waiting : {{$ser->queues_count}}</p>
                        <p>currently queue serving : {{$ser->current_queue_id ? $ser->current_queue_id : 'no one'}}</p>
                        @if (app(App\Repository\QueueRepository::class)->isQueue($ser->id))
                            <p>The rest is your turn : {{app(App\Repository\QueueRepository::class)->myQueue($ser->id)->number - $ser->current_queue_id}}</p>
                            <p class="text-red-500 my-3">You have already booked a ticket</p>
                        @else
                            @auth
                                
                            @if (auth()->user()->type!=="admin")
                                <form action="{{ route('ticket.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $ser->id }}">
                                    <input type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1"
                                        value="Ticket booking">
                                </form>

                            @else (auth()->user()->type=="admin")
                                <a class="bg-green-500 text-white font-weight-bold shadow p-1 my-3"
                                    href="{{ route('ticket.index',[$ser->id,'state'=>"waiting"]) }}">Show
                                    Tickets</a>
                            @endif
                            @endauth

                            @guest
                            <form class="my-3" action="{{ route('ticket.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $ser->id }}">
                                <input type="submit" class="bg-green-500 text-white font-weight-bold shadow p-1"
                                    value="Ticket booking">
                            </form>
                            @endguest
                        @endif
                    </div>
                @endforeach
            </div>







        </div>
    </div>
</x-app-layout>
