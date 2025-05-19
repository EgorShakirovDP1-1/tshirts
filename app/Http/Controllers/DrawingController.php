<?php

namespace App\Http\Controllers;

use App\Models\Drawing;
use App\Models\Category;
use App\Models\Thing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Foundation\Validation\ValidatesRequests;
class DrawingController extends Controller
{
    use AuthorizesRequests;
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
    $thing = Thing::find($request->thing_id);
if ($thing) {
    $thing->drawing_id = $drawing->id;
    $thing->save();
}
    // 🔁 Attach categories to the pivot table
    $drawing->categories()->sync($request->categories);

    // ✅ Redirect to editing page
    return redirect()->route('drawings.edit', $drawing)
        ->with('success', 'Drawing created! Now you can edit details.');
}

    public function edit(Drawing $drawing)
{
    $this->authorize('update', $drawing);
    $categories = Category::all();
    return view('gallery.edit', compact('drawing', 'categories'));
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

    return redirect()->route('drawings.update', $drawing)->with('success', 'Drawing updated successfully!');
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

    $query = Drawing::with(['user', 'categories', 'likes'])
        ->withCount([
            'likes as rating_sum' => function ($query) {
                $query->select(DB::raw("SUM(rating)"));
            }
        ]);

    $this->applySearch($request, $query);
    $this->applyFilter($request, $query);
    $this->applySorting($request, $query);

    $drawings = $query->paginate(12)->withQueryString();

    return view('gallery.index', compact('drawings', 'categories'));
}

private function applySearch(Request $request, &$query)
{
    if ($request->filled('query')) {
        $search = $request->input('query');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('username', 'like', "%{$search}%");
              });
        });
    }
}

private function applyFilter(Request $request, &$query)
{
    if ($request->filled('categories')) {
        $categoryIds = $request->input('categories');
        $query->whereHas('categories', function ($q) use ($categoryIds) {
            $q->whereIn('categories.id', $categoryIds);
        });
    }
}

private function applySorting(Request $request, &$query)
{
    if ($request->input('sort') === 'rating') {
        $query->orderByDesc('rating_sum');
    } else {
        $query->orderByDesc('created_at');
    }
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

public function createFromThing(Thing $thing)
{
    $categories = Category::all();
    return view('draw', compact('categories', 'thing'));
}
public function chooseThing()
{
    $things = Thing::whereNotNull('path_to_img')
        ->where('user_id', auth()->id())
        ->get();
    return view('draw.choose-thing', compact('things'));
}
}
