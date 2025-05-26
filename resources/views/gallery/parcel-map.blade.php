<!-- filepath: resources/views/gallery/parcel-map.blade.php -->
<x-app-layout>
    <div class="container mx-auto my-5 px-4">
        <h2 class="text-2xl font-bold mb-4">Select a parcel machine for delivering the drawing "{{ $drawing->name }}"</h2>
        <ul class="mb-8">
            @foreach($parcelMachines as $machine)
                <li class="mb-3 p-3 border rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $machine->name }}</strong><br>
                        Delivery price: {{ $machine->delivery_price }} €<br>
                        Coordinates: {{ $machine->latitude }}, {{ $machine->longitude }}
                    </div>
                    <form action="{{ route('deliveries.store', $drawing) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parcel_machine_id" value="{{ $machine->id }}">
                        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                            Choose this parcel machine
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
        <div class="flex gap-4">
            <a href="{{ route('drawings.show', $drawing) }}" class="text-blue-500 underline">Back to drawing</a>
            <a href="{{ route('deliveries.all') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 font-semibold">
                All deliveries
            </a>
        </div>
    </div>
</x-app-layout>