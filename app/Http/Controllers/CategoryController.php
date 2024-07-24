<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories.index');
    }

    public function getData()
    {
        $categories = Category::query();
        return DataTables::of($categories)
                                    ->editColumn('image', function($category){
                                        $imagePath = asset('storage' . $category->image);
                                        return '<img src="'.$imagePath.'" alt="Image" height="50" width="50">';
                                    }) 
                                    ->rawColumns(['image'])  
                                    ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'required|string',
            'status' => 'required|in:active,draft',
            'image.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);
        
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->status = $request->status;

        // Upload image if provided
        if ($request->hasFile('image')) {
            $images = [];
            foreach ($request->file('image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public', $imageName);
                $images[] = $imageName;
            }
            $category->image = implode(',', $images);
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            // Find the category by its ID
    $category = Category::findOrFail($id);

    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string',
        'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($category->image) {
            Storage::delete('public/' . $category->image);
        }
        // Store the new image
        $imagePath = $request->file('image')[0]->store('categories', 'public');
        $category->image = $imagePath;
    }

    // Update other fields of the category
    $category->name = $request->name;
    $category->slug = $request->slug;
    $category->description = $request->description;
    $category->status = $request->status;
    $category->save();   
    return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
