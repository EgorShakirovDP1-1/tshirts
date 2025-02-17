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
   
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to upload.');
        }

        $request->validate([
            'image' => 'required|image|mimes:png|max:2048',
            'material_id' => 'required|exists:materials,id',
        ]);

        $path = $request->file('image')->store('things', 'public');

        Thing::create([
            'user_id' => Auth::id(), // Ensure user_id is set correctly
            'path_to_img' => $path,
            'material_id' => $request->material_id,
            
        ]);

        return redirect()->route('profile.create')->with('success', 'Thing uploaded successfully!');
    }
}