<?php

namespace App\Http\Controllers;

use App\Models\Drawing;
use App\Models\ParcelMachine;
use Illuminate\Http\Request;

class ParcelMapController extends Controller
{
    public function index()
    {
        $parcelMachines = ParcelMachine::all();
        return view('gallery.parcel-map', compact('parcelMachines'));
    }

    public function calculateDeliveryPrices()
    {
        $parcelMachines = ParcelMachine::all();
        $drawings = Drawing::with(['thing.material'])->get();

        $results = [];

        foreach ($drawings as $drawing) {
            foreach ($parcelMachines as $machine) {
                // Базовая цена доставки от ParcelMachine
                $basePrice = $machine->delivery_price;

                // Цена материала (например, можно хранить в поле price, если есть)
                $materialPrice = $drawing->thing->material->price ?? 1.0; // если нет поля price, используйте 1.0

                // Цена рисунка (например, можно хранить в поле price, если есть)
                $drawingPrice = $drawing->price ?? 2.0; // если нет поля price, используйте 2.0

                // Случайная надбавка (например, от 0 до 1 евро)
                $random = mt_rand(0, 100) / 100;

                // Итоговая цена
                $total = $basePrice + $materialPrice + $drawingPrice + $random;

                $results[] = [
                    'drawing_id' => $drawing->id,
                    'drawing_name' => $drawing->name,
                    'parcel_machine' => $machine->name,
                    'delivery_price' => round($total, 2),
                ];
            }
        }

        // Можно вернуть как JSON или передать в Blade
        return response()->json($results);
    }

    // Показывает список постаматов для выбранного рисунка
    public function showParcelMap(Drawing $drawing)
    {
        // Только владелец рисунка может видеть страницу выбора постамата
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'Вы не можете доставлять чужие рисунки.');
        }

        $parcelMachines = \App\Models\ParcelMachine::all();
        return view('gallery.parcel-map', compact('drawing', 'parcelMachines'));
    }

    // Обрабатывает выбор постамата и сохраняет цену
    public function chooseParcel(Request $request, Drawing $drawing)
    {
        // Только владелец рисунка может выбрать постамат
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'Вы не можете доставлять чужие рисунки.');
        }

        $request->validate([
            'parcel_machine_id' => 'required|exists:parcel_machines,id',
        ]);

        $parcelMachine = \App\Models\ParcelMachine::findOrFail($request->parcel_machine_id);

        $thing = $drawing->thing->first();
        $materialPrice = $thing?->material?->price ?? 1.0;
        $drawingPrice = $drawing->price ?? 2.0;
        $random = mt_rand(0, 100) / 100;
        $total = $parcelMachine->delivery_price + $materialPrice + $drawingPrice + $random;

        $drawing->parcel_machine_id = $parcelMachine->id;
        $drawing->total_price = round($total, 2);
        $drawing->save();

        return redirect()->route('drawings.show', $drawing)->with('success', 'Постамат выбран, цена доставки рассчитана!');
    }
}