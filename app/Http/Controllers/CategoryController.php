<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('service')->get();
        $services = Service::all();
        return view('admin.categories.index', compact('categories', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255'
        ]);

        Category::create($request->only('service_id', 'name'));
        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil ditambahkan');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255'
        ]);

        $category->update($request->only('service_id', 'name'));
        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil dihapus');
    }
}
