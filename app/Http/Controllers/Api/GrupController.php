<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grup;
use Illuminate\Http\Request;

class GrupController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on grup']);
    }

    public function index()
    {
        $grup = Grup::all();
        return response()->json($grup, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grup = Grup::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json(['grup' => $grup, 'message' => 'Grup created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grup = Grup::findOrFail($id);
        $grup->name = $validatedData['name'];
        $grup->save();

        return response()->json(['grup' => $grup, 'message' => 'Grup updated successfully'], 200);
    }

    public function destroy($id)
    {
        $grup = Grup::findOrFail($id);
        $grup->delete();

        return response()->json(['message' => 'Grup deleted successfully'], 204);
    }
}
