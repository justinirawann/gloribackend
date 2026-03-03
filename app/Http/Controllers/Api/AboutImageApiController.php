<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutImage;

class AboutImageApiController extends Controller
{
    public function index()
    {
        $images = AboutImage::all()->keyBy('type');
        return response()->json($images);
    }
}
