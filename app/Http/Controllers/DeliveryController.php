<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Drawing;
use App\Models\ParcelMachine;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Показать все доставки пользователя
    public function allDeliveries()
    {
        $deliveries = \App\Models\Delivery::with(['drawing', 'parcelMachine'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.delivery-info', compact('deliveries'));
    }

    // Показать одну доставку (детали)
    public function show(Delivery $delivery)
    {
        $deliveries = Delivery::with(['drawing', 'parcelMachine'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.delivery-info', [
            'deliveryInfo' => $delivery,
            'deliveries' => $deliveries,
        ]);
    }

    // Показывает форму выбора постамата для доставки
    public function create(Drawing $drawing)
    {
        if (!$drawing->thing()->exists()) {
    return redirect()
        ->route('drawings.show', $drawing)
        ->with('error', 'Нельзя оформить доставку: рисунок не связан ни с одним объектом!');
}
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'You can only deliver your own drawings.');
        }
        $parcelMachines = ParcelMachine::all();
        return view('gallery.parcel-map', compact('drawing', 'parcelMachines'));
    }

    // Сохраняет новую доставку
    public function store(Request $request, Drawing $drawing)
    {
        if (!$drawing->thing()->exists()) {
    return redirect()
        ->route('drawings.show', $drawing)
        ->with('error', 'Нельзя оформить доставку: рисунок не связан ни с одним объектом!');
}
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'You can only deliver your own drawings.');
        }

        $request->validate([
            'parcel_machine_id' => 'required|exists:parcel_machines,id',
        ]);

        $parcelMachine = ParcelMachine::findOrFail($request->parcel_machine_id);

        $thing = $drawing->thing->first();
        $materialPrice = $thing?->material?->price ?? 1.0;
        $drawingPrice = $drawing->price ?? 2.0;
        $random = mt_rand(0, 100) / 100;
        $total = $parcelMachine->delivery_price + $materialPrice + $drawingPrice + $random;

        $delivery = Delivery::create([
            'drawing_id' => $drawing->id,
            'user_id' => auth()->id(),
            'parcel_machine_id' => $parcelMachine->id,
            'total_price' => round($total, 2),
            'status' => 'pending',
        ]);

        return redirect()->route('deliveries.show', $drawing)
            ->with('success', 'Parcel machine selected, delivery created!');
    }

    // (Опционально) Удаление доставки
    public function destroy(Delivery $delivery)
    {
        $this->authorize('delete', $delivery);
        $delivery->delete();
        return back()->with('success', 'Delivery deleted.');
    }
}
