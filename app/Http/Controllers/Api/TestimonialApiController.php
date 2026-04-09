<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Testimonial::with('portfolio')->latest()->get()
        );
    }
}
