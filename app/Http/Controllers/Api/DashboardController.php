<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dari request
        $instansi_id = $request->input("instanses_id");
        $grup_id = $request->input("grup_id");
        $user_id = $request->input("user_id");

        // Inisialisasi variabel hasil
        $totalPermohonan = 0;
        $permohonanBelumdikerjakan = 0;
        $permohonanSedangDikerjakan = 0;
        $permohonanSelesai = 0;

        // Kondisi berdasarkan grup_id
        if ($grup_id == 3) {
            // Untuk user biasa, ambil data berdasarkan user_id
            $totalPermohonan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("user_id", $user_id)
                ->count();

            $permohonanBelumdikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("user_id", $user_id)
                ->where('status_id', 1)
                ->count();

            $permohonanSedangDikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("user_id", $user_id)
                ->where('status_id', 2)
                ->count();

            $permohonanSelesai = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("user_id", $user_id)
                ->where('status_id', 3)
                ->count();
        } elseif ($grup_id == 2) {
            // Untuk admin OPD, ambil data berdasarkan instansi_id
            $totalPermohonan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("instanses_id", $instansi_id)
                ->count();

            $permohonanBelumdikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("instanses_id", $instansi_id)
                ->where('status_id', 1)
                ->count();

            $permohonanSedangDikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("instanses_id", $instansi_id)
                ->where('status_id', 2)
                ->count();

            $permohonanSelesai = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where("instanses_id", $instansi_id)
                ->where('status_id', 3)
                ->count();
        } else {
            // Untuk admin, ambil semua permohonan
            $totalPermohonan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->count();

            $permohonanBelumdikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where('status_id', 1)
                ->count();

            $permohonanSedangDikerjakan = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where('status_id', 2)
                ->count();

            $permohonanSelesai = Permohonan::with('user', 'instanses', 'category', 'status')
                ->where('status_id', 3)
                ->count();
        }

        // Kembalikan data dalam bentuk JSON
        return response()->json([
            'totalPermohonan' => $totalPermohonan,
            'permohonanBelumdikerjakan' => $permohonanBelumdikerjakan,
            'permohonanSedangDikerjakan' => $permohonanSedangDikerjakan,
            'permohonanSelesai' => $permohonanSelesai,
        ], 200);
    }

    // public function getPermohonanChartData()
    // {
    //     // Mengambil dan menghitung jumlah permohonan berdasarkan status_id
    //     $permohonanData = Permohonan::select('status_id', DB::raw('count(*) as total'))
    //         ->groupBy('status_id')
    //         ->get();

    //     // Format data untuk chart
    //     $labels = [];
    //     $values = [];

    //     foreach ($permohonanData as $data) {
    //         $labels[] = 'Status ' . $data->status_id;  // Sesuaikan label sesuai kebutuhan
    //         $values[] = $data->total;
    //     }

    //     // Mengembalikan data dalam format JSON
    //     return response()->json([
    //         'labels' => $labels,
    //         'values' => $values,
    //     ]);
    // }
}
