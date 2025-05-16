<!-- filepath: resources/views/gallery/parcel-map.blade.php -->
<x-app-layout>
    <div class="container mx-auto my-5 px-4">
        <h2 class="text-2xl font-bold mb-4">Выберите постамат для доставки рисунка "{{ $drawing->name }}"</h2>
        <ul class="mb-8">
            @foreach($parcelMachines as $machine)
                <li class="mb-3 p-3 border rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $machine->name }}</strong><br>
                        Цена доставки: {{ $machine->delivery_price }} €<br>
                        Координаты: {{ $machine->latitude }}, {{ $machine->longitude }}
                    </div>
                    <form action="{{ route('drawings.choose-parcel', $drawing) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parcel_machine_id" value="{{ $machine->id }}">
                        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                            Выбрать этот постамат
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('drawings.show', $drawing) }}" class="text-blue-500 underline">Назад к рисунку</a>
    </div>
</x-app-layout>