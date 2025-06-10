<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }
    public function index()
    {
        $Category=Category::all();
        return response()->json(
            $Category,200
        );
    }
}

