<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instanses; // Model Instanses untuk akses tabel instanses
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    // Test route untuk cek koneksi API
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }


    public function index()
    {
        $instansis = Instanses::all();
        return response()->json($instansis, 200);
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $instansi = Instanses::create([
            'name' => $validatedData['name'],
        ]);


        return response()->json($instansi, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $instansi = Instanses::findOrFail($id);
        $instansi->name = $validatedData['name'];
        $instansi->save();

        return response()->json(['grup' => $instansi, 'message' => 'Instansi updated successfully'], 200);
    }

    public function destroy($id)
    {

        $instansi = Instanses::findOrFail($id);

        $instansi->delete();

        return response()->json(null, 204);
    }
}
