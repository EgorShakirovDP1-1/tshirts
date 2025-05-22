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
        $deliveryInfo = $delivery->load('drawing', 'parcelMachine');
        $deliveries = \App\Models\Delivery::with(['drawing', 'parcelMachine'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.delivery-info', compact('deliveries', 'deliveryInfo'));
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

        // Проверка: уже есть доставка для этого рисунка
        if (Delivery::where('drawing_id', $drawing->id)->exists()) {
            return redirect()
                ->route('drawings.show', $drawing)
                ->with('error', 'Доставка для этого рисунка уже оформлена!');
        }

        $request->validate([
            'parcel_machine_id' => 'required|exists:parcel_machines,id',
        ]);

        $parcelMachine = ParcelMachine::findOrFail($request->parcel_machine_id);

        $thing = $drawing->thing->first();

        // Цена материала зависит от количества символов в названии thing (если есть)
        $materialNameLength = $thing ? mb_strlen($thing->name ?? '') : 0;
        $materialPrice = 1.0 + ($materialNameLength * 0.15);

        // Цена рисунка зависит от количества символов в названии рисунка
        $drawingNameLength = mb_strlen($drawing->name ?? '');
        $drawingPrice = 2.0 + ($drawingNameLength * 0.07);

        // Немного случайности
        $random = mt_rand(0, 100) / 100;

        $total = $parcelMachine->delivery_price + $materialPrice + $drawingPrice + $random;

        $delivery = Delivery::create([
            'drawing_id' => $drawing->id,
            'user_id' => auth()->id(),
            'parcel_machine_id' => $parcelMachine->id,
            'price' => $total,            'total_price' => round($total, 2),
        ]);

    return redirect()->route('deliveries.all')->with('success', 'Доставка успешно оформлена!');
}

// (Опционально) Удаление доставки
public function destroy(Delivery $delivery)
{
    $this->authorize('delete', $delivery);
    $delivery->delete();
    return back()->with('success', 'Delivery deleted.');
}
}
