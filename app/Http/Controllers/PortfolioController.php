<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with(['service', 'images'])->get();
        $services = Service::all();
        $categories = Category::all();
        return view('admin.portfolios.index', compact('portfolios', 'services', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'description_en' => 'nullable|string',
                'category' => 'required|string|max:255',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
            ]);

            $data = $request->only('service_id', 'name', 'description', 'description_en', 'category');
            
            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')->store('portfolios', 'public');
            }

            Portfolio::create($data);
            return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.portfolios.index')->with('error', 'Gagal menambahkan portfolio: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        try {
            $validated = $request->validate([
                'service_id' => 'required|exists:services,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'description_en' => 'nullable|string',
                'category' => 'required|string|max:255',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
            ]);

            $portfolio->service_id = $validated['service_id'];
            $portfolio->name = $validated['name'];
            $portfolio->description = $validated['description'];
            $portfolio->description_en = $validated['description_en'] ?? null;
            $portfolio->category = $validated['category'];
            
            if ($request->hasFile('banner_image')) {
                if ($portfolio->banner_image) {
                    \Storage::disk('public')->delete($portfolio->banner_image);
                }
                $portfolio->banner_image = $request->file('banner_image')->store('portfolios', 'public');
            }

            $portfolio->save();
            return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->route('admin.portfolios.index')->with('error', 'Gagal update portfolio: ' . $e->getMessage());
        }
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->banner_image) {
            \Storage::disk('public')->delete($portfolio->banner_image);
        }
        $portfolio->delete();
        return redirect()->route('admin.portfolios.index')->with('success', 'Portfolio berhasil dihapus');
    }
}
