<!-- filepath: resources/views/gallery/delivery-info.blade.php -->
<x-app-layout>
    <div class="max-w-4xl mx-auto my-10 px-4">
        <h1 class="text-3xl font-bold text-candy mb-6">My Deliveries</h1>

        @if($deliveries->isEmpty())
            <div class="bg-yellow-100 p-6 rounded-xl shadow mb-6">
                <p>You have no deliveries yet.</p>
            </div>
        @else
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full bg-white rounded-xl shadow">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Drawing</th>
                            <th class="px-4 py-2">Parcel Machine</th>
                            <th class="px-4 py-2">Price (€)</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Created</th>
                            <th class="px-4 py-2">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                            <tr class="border-t">
                                <td class="px-4 py-2">
                                    {{ $delivery->drawing->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $delivery->parcelMachine->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $delivery->total_price }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ ucfirst($delivery->status) }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $delivery->created_at ? $delivery->created_at->format('d.m.Y H:i') : '—' }}
                                </td>
                                <td class="px-4 py-2">
                                   <a href="{{ route('deliveries.show', ['delivery' => $delivery->id]) }}" class="text-blue-600 underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        @isset($deliveryInfo)
            <div class="bg-pink-50 rounded-xl shadow p-6">
                <h2 class="text-xl font-bold mb-4">Delivery Details</h2>
                <p><strong>Drawing:</strong> {{ $deliveryInfo->drawing->name ?? '—' }}</p>
                <p><strong>Parcel Machine:</strong> {{ $deliveryInfo->parcelMachine->name ?? '—' }}</p>
                <p><strong>Coordinates:</strong> {{ $deliveryInfo->parcelMachine->latitude ?? '—' }}, {{ $deliveryInfo->parcelMachine->longitude ?? '—' }}</p>
                <p><strong>Price:</strong> {{ $deliveryInfo->total_price }} €</p>
                <p><strong>Status:</strong> {{ ucfirst($deliveryInfo->status) }}</p>
                <p><strong>Created:</strong> {{ $deliveryInfo->created_at ? $deliveryInfo->created_at->format('d.m.Y H:i') : '—' }}</p>
            </div>
        @endisset
    </div>
</x-app-layout>