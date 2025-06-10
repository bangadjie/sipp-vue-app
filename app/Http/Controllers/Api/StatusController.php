<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Statuses;
use App\Models\Instansi;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }
    public function index()
    {
        $Statuses=Statuses::all();
        return response()->json(
            $Statuses,200
        );
    }
}

