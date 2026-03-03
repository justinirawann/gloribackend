<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;

class PortfolioImageController extends Controller
{
    public function manage($portfolioId)
    {
        $portfolio = Portfolio::with('images')->findOrFail($portfolioId);
        return view('admin.portfolios.images', compact('portfolio'));
    }

    public function upload(Request $request, $portfolioId)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
        ]);

        $portfolio = Portfolio::findOrFail($portfolioId);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('portfolio_images', 'public');
                PortfolioImage::create([
                    'portfolio_id' => $portfolio->id,
                    'image_path' => $path,
                    'display_order' => 0,
                    'is_displayed' => false
                ]);
            }
        }

        return redirect()->route('admin.portfolios.images.manage', $portfolioId)->with('success', 'Images uploaded successfully');
    }

    public function updateDisplay(Request $request, $portfolioId)
    {
        $request->validate([
            'displayed_images' => 'required|array|max:5',
            'displayed_images.*' => 'exists:portfolio_images,id'
        ]);

        $portfolio = Portfolio::findOrFail($portfolioId);
        
        // Reset all images
        PortfolioImage::where('portfolio_id', $portfolioId)->update(['is_displayed' => false, 'display_order' => 0]);

        // Set selected images with order
        foreach ($request->displayed_images as $order => $imageId) {
            PortfolioImage::where('id', $imageId)->update([
                'is_displayed' => true,
                'display_order' => $order + 1
            ]);
        }

        return redirect()->route('admin.portfolios.images.manage', $portfolioId)->with('success', 'Display images updated successfully');
    }

    public function delete($imageId)
    {
        $image = PortfolioImage::findOrFail($imageId);
        \Storage::disk('public')->delete($image->image_path);
        $portfolioId = $image->portfolio_id;
        $image->delete();

        return redirect()->route('admin.portfolios.images.manage', $portfolioId)->with('success', 'Image deleted successfully');
    }

    public function deleteAll($portfolioId)
    {
        $portfolio = Portfolio::findOrFail($portfolioId);
        
        foreach ($portfolio->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        return redirect()->route('admin.portfolios.images.manage', $portfolioId)->with('success', 'All images deleted successfully');
    }
}
