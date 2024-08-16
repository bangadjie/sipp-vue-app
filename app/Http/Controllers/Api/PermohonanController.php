<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on grups']);
    }

    public function index()
    {
        return response()->json(
            Permohonan::with('instanses', 'category', 'status')->get(), 200
        );
    }

    // Store new permohonan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instanses_id' => 'required|exists:instanses,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $permohonan = Permohonan::create($validated);

        return response()->json($permohonan, 201);
    }

    // Update existing permohonan
    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        $validated = $request->validate([
            'instanses_id' => 'required|exists:instanses,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        $permohonan->update($validated);

        return response()->json($permohonan);
    }

    // Delete permohonan
    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->delete();

        return response()->json(['message' => 'Permohonan deleted successfully']);
    }
}
