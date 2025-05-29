<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thing;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ThingController extends Controller
{
    /**
     * Show the upload form.
     */
 

    public function create()
    {
        $materials = Material::all();
        return view('profile.Create.create', compact('materials'));
    }

    /**
     * Store the uploaded PNG image and link to material.
     */
   
    public function store(Request $request) //not working
    {
        // dd($request->input('compressed_image')); // 🧪 Debug compressed image content
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to upload.');
        }

        $request->validate([
            'compressed_image' => 'required|string',
            'material_id' => 'required|exists:materials,id',
        ]);
        
        $data = $request->input('compressed_image');
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        $fileName = 'things/' . uniqid() . '.png';
        
        Storage::disk('public')->put($fileName, $data);

        // Save to DB
        $thing = Thing::create([
            'user_id' => auth()->id(),
            'material_id' => $request->material_id,
            'path_to_img' => $fileName,
        ]);

        // Проверка доступности файла и автудаление, если не найден
        if (!Storage::disk('public')->exists($fileName)) {
            $thing->delete();
            return redirect()->route('draw')->with('error', 'Image upload failed, thing was not saved.');
        }

        return redirect()->route('draw')->with('success', 'Thing uploaded successfully!');
    }
    
}