<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('portfolio')->latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $portfolios = Portfolio::whereDoesntHave('testimonial')->get();
        return view('admin.testimonials.create', compact('portfolios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'industry'     => 'required|string|max:255',
            'rating'       => 'required|numeric|min:1|max:5',
            'description'  => 'required|string',
            'project_date' => 'required|date',
            'portfolio_id' => 'nullable|exists:portfolios,id|unique:testimonials,portfolio_id',
        ]);

        Testimonial::create($request->all());
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        $portfolios = Portfolio::whereDoesntHave('testimonial')
            ->orWhere('id', $testimonial->portfolio_id)
            ->get();
        return view('admin.testimonials.edit', compact('testimonial', 'portfolios'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'industry'     => 'required|string|max:255',
            'rating'       => 'required|numeric|min:1|max:5',
            'description'  => 'required|string',
            'project_date' => 'required|date',
            'portfolio_id' => 'nullable|exists:portfolios,id|unique:testimonials,portfolio_id,' . $testimonial->id,
        ]);

        $testimonial->update($request->all());
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diupdate.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
