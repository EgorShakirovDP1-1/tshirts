<?php

namespace App\Http\Controllers;

use App\Models\Drawing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DrawingController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('draw', compact('categories'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'drawing_data' => 'required',
            'name' => 'required|string|max:255',
            'categories' => 'array|exists:categories,id',
        ]);
    
        $drawingData = $request->input('drawing_data');
        $decodedData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $drawingData));
    
        $fileName = 'drawings/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $decodedData);
    
        $drawing = Drawing::create([
            'path_to_drawing' => $fileName,
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);
    
        $drawing->categories()->sync($request->categories);
    
        return redirect()->route('drawings.edit', $drawing)->with('success', 'Drawing created! Now you can edit details.');
    }
    

    public function edit(Drawing $drawing)
{
    $this->authorize('update', $drawing);
    $categories = Category::all();
    return view('drawings.edit', compact('drawing', 'categories'));
}


public function update(Request $request, Drawing $drawing)
{
    $this->authorize('update', $drawing);

    $request->validate([
        'name' => 'required|string|max:255',
        'categories' => 'array|exists:categories,id',
    ]);

    $drawing->update([
        'name' => $request->name,
    ]);

    $drawing->categories()->sync($request->categories);

    return redirect()->route('gallery.edit', $drawing)->with('success', 'Drawing updated successfully!');
}


public function destroy(Drawing $drawing)
{
    $this->authorize('delete', $drawing);

    $drawing->categories()->detach();
    Storage::disk('public')->delete($drawing->path_to_drawing);
    $drawing->delete();

    return redirect()->route('gallery.index')->with('success', 'Drawing deleted successfully!');
}


public function index(Request $request)
{
    $categories = Category::all();

    $query = Drawing::with(['user', 'categories'])
        ->withCount([
            'likes as rating_sum' => function ($query) {
                $query->select(DB::raw("SUM(rating)"));
            }
        ]);

    // 🔍 Search
    if ($request->filled('query')) {
        $search = $request->input('query');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('username', 'like', "%{$search}%");
              });
        });
    }

    // 🧮 Filter by categories
    if ($request->filled('categories')) {
        $categoryIds = $request->input('categories');
        $query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }

    // 🔀 Sort
    if ($request->input('sort') === 'rating') {
        $query->orderByDesc('rating_sum');
    } else {
        $query->orderByDesc('created_at');
    }

    $drawings = $query->paginate(12)->withQueryString();

    return view('gallery.index', compact('drawings', 'categories'));
}
public function show($id)
{
    $drawing = Drawing::with('user')->findOrFail($id);
    return view('gallery.show', compact('drawing'));
}
public function search(Request $request)
{
    $query = $request->input('query');

    $drawings = Drawing::with('user', 'categories')
        ->where('name', 'like', '%' . $query . '%')
        ->orWhereHas('user', function ($q) use ($query) {
            $q->where('username', 'like', '%' . $query . '%');
        })
        ->get();

    $categories = Category::all();

    return view('gallery.index', compact('drawings', 'categories'));
}


public function my()
{
    $drawings = Drawing::with('categories')->where('user_id', auth()->id())->get();
    return view('gallery.my', compact('drawings'));
}

}
