<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanController extends Controller
{

    public function index(Request $request)
    {
        // Ambil parameter dari request
        $instansi_id = $request->input("instanses_id");
        $grup_id = $request->input("grup_id");
        $user_id = $request->input("user_id");
        if ($grup_id == 3) {
            $query = Permohonan::with('user', 'instanses', 'category', 'status')->where("user_id", $user_id);
        } elseif ($grup_id == 2) {
            $query = Permohonan::with('user', 'instanses', 'category', 'status')->where("instanses_id", $instansi_id);
        } else {
            $query = Permohonan::with('user', 'instanses', 'category', 'status');
        }

        // Ambil hasil query
        $permohonans = $query->get();

        // Kembalikan hasil sebagai JSON
        return response()->json($permohonans, 200);
    }

    // Store new permohonan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'instanses_id' => 'required|exists:instanses,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            // 'status_id' => 'required|string',
        ]);

        $permohonan = Permohonan::create([
            'user_id' => $validated['user_id'],
            'instanses_id' => $validated['instanses_id'],
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'deskripsi' => $validated['deskripsi'],
            'status_id' => 1,
        ]);

        return response()->json($permohonan, 201);
    }


    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::find($id);

        if (!$permohonan) {
            return response()->json(['message' => 'Permohonan not found'], 404);
        }

        $permohonan->instanses_id = $request->instanses_id;
        $permohonan->category_id = $request->category_id;
        $permohonan->name = $request->name;
        $permohonan->deskripsi = $request->deskripsi;
        $permohonan->status_id = $request->status_id;

        if ($permohonan->status_id !== $request->status_id) {
            $permohonan->status_id = $request->status_id;
            // $permohonan->status_changed_at = now(); // Set waktu perubahan status
        }

        $permohonan->created_at = now(); // Menetapkan waktu saat ini

        $permohonan->save();

        return response()->json($permohonan, 200);
    }

    // Delete permohonan
    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->delete();

        return response()->json(['message' => 'Permohonan deleted successfully']);
    }

    public function getPermohonanChartData()
    {
        // Query data dari database
        $permohonanData = Permohonan::select('status_id', DB::raw('count(*) as total'))
            ->groupBy('status_id')
            ->get();

        $labels = $permohonanData->pluck('status_id');  // Mengambil ID status sebagai label
        $values = $permohonanData->pluck('total');  // Mengambil total jumlah permohonan untuk tiap status

        return response()->json([
            'selesai' => 30,
            'belum' => 50,
            'progres' => 10
        ]);
    }

    public function uploadPhoto(Request $request, $id)
    {
        // Cari permohonan berdasarkan ID
        $permohonan = Permohonan::find($id);

        if (!$permohonan) {
            return response()->json(['message' => 'Permohonan not found'], 404);
        }

        // Validasi file gambar
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // Simpan file gambar ke folder public
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName, 'public'); // Simpan ke folder storage/public/uploads

            // Simpan path gambar di database, jika diperlukan
            $permohonan->photo_path = '/storage/' . $filePath;
            $permohonan->save();

            return response()->json([
                'message' => 'Foto berhasil diunggah!',
                'photo_path' => $permohonan->photo_path,
            ], 200);
        }
    }
}
