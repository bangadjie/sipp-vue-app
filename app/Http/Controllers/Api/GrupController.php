<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grup;
use Illuminate\Http\Request;

class GrupController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }
    public function index()
    {
        $grup=Grup::all();
        return response()->json(
            $grup,200
        );
    }
}

