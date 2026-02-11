<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientLogo;

class ClientLogoApiController extends Controller
{
    public function index()
    {
        $logos = ClientLogo::all();
        return response()->json($logos);
    }
}
