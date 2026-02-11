<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingImage;

class LandingImageApiController extends Controller
{
    public function index()
    {
        $images = LandingImage::orderBy('order')->get();
        return response()->json($images);
    }
}
