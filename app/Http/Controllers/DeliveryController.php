<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Drawing;
use App\Models\ParcelMachine;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // Show all deliveries for the user
    public function allDeliveries()
    {
        $deliveries = \App\Models\Delivery::with(['drawing', 'parcelMachine'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.delivery-info', compact('deliveries'));
    }

    // Show a single delivery (details)
    public function show(Delivery $delivery)
    {
        $deliveryInfo = $delivery->load('drawing', 'parcelMachine');
        $deliveries = \App\Models\Delivery::with(['drawing', 'parcelMachine'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('gallery.delivery-info', compact('deliveries', 'deliveryInfo'));
    }

    // Show the form for selecting a parcel machine for delivery
    public function create(Drawing $drawing)
    {
        if (!$drawing->thing()->exists()) {
            return redirect()
                ->route('drawings.show', $drawing)
                ->with('error', 'Cannot create delivery: the drawing is not linked to any thing!');
        }
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'You can only deliver your own drawings.');
        }
        $parcelMachines = ParcelMachine::all();
        return view('gallery.parcel-map', compact('drawing', 'parcelMachines'));
    }

    // Store a new delivery
    public function store(Request $request, Drawing $drawing)
    {
        if (!$drawing->thing()->exists()) {
            return redirect()
                ->route('drawings.show', $drawing)
                ->with('error', 'Cannot create delivery: the drawing is not linked to any thing!');
        }
        if (auth()->id() !== $drawing->user_id) {
            abort(403, 'You can only deliver your own drawings.');
        }

        // Check: delivery already exists for this drawing
        if (Delivery::where('drawing_id', $drawing->id)->exists()) {
            return redirect()
                ->route('drawings.show', $drawing)
                ->with('error', 'A delivery for this drawing already exists!');
        }

        $request->validate([
            'parcel_machine_id' => 'required|exists:parcel_machines,id',
        ]);

        $parcelMachine = ParcelMachine::findOrFail($request->parcel_machine_id);

        $thing = $drawing->thing->first();

        // Material price depends on the number of characters in the thing's name (if any)
        $materialNameLength = $thing ? mb_strlen($thing->name ?? '') : 0;
        $materialPrice = 1.0 + ($materialNameLength * 0.15);

        // Drawing price depends on the number of characters in the drawing's name
        $drawingNameLength = mb_strlen($drawing->name ?? '');
        $drawingPrice = 2.0 + ($drawingNameLength * 0.07);

        // Add some randomness
        $random = mt_rand(0, 100) / 100;

        $total = $parcelMachine->delivery_price + $materialPrice + $drawingPrice + $random;

        $delivery = Delivery::create([
            'drawing_id' => $drawing->id,
            'user_id' => auth()->id(),
            'parcel_machine_id' => $parcelMachine->id,
            'price' => $total,
            'total_price' => round($total, 2),
        ]);

        return redirect()->route('deliveries.all')->with('success', 'Delivery created successfully!');
    }

    // (Optional) Delete a delivery
    public function destroy(Delivery $delivery)
    {
        $this->authorize('delete', $delivery);
        $delivery->delete();
        return back()->with('success', 'Delivery deleted.');
    }
}
