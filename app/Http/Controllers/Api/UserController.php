<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }
    public function index()
    {
        $user=User::with('instanses','grup')->get();
        return response()->json(
            $user,200
        );
    }
}

