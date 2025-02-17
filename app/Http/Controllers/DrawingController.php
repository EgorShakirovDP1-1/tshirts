<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Drawing;

class DrawingController extends Controller
{
    /**
     * Store the drawing to storage and database.
     */
    public function store(Request $request)
{
    $request->validate([
        'drawing_data' => 'required',
        'name' => 'required|string|max:255',
    ]);

    $drawingData = $request->input('drawing_data');
    $decodedData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $drawingData));

    $fileName = 'drawings/' . uniqid() . '.png';
    Storage::disk('public')->put($fileName, $decodedData);

    Drawing::create([
        'path_to_drawing' => $fileName,
        'name' => $request->name,
        'user_id' => auth()->id(),
    ]);

    return redirect()->route('profile.edit')->with('success', 'Drawing saved successfully!');
}

}
