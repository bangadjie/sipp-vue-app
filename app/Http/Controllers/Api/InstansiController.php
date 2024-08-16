<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instanses;
use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }
    public function index()
    {
        $Instanses=Instanses::all();
        return response()->json(
            $Instanses,200
        );
    }
}

