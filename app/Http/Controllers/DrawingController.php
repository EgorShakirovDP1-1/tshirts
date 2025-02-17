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
            'drawing_data' => 'required', // Validate the drawing data
            'name' => 'required|string|max:255', // Validate the drawing name
        ]);

        // Decode the Base64 image data
        $drawingData = $request->input('drawing_data');
        $decodedData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $drawingData));

        // Create a unique filename
        $fileName = 'drawings/' . uniqid() . '.png';

        // Store the file in the storage (public disk)
        Storage::disk('public')->put($fileName, $decodedData);

        // Save the path and user information in the database
        Drawing::create([
            'path_to_drawing' => $fileName,
            'name' => $request->input('name'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Drawing saved successfully!');


    }
}
