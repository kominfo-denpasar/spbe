<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Opd;
use App\Models\Katapp;
use App\Models\Layananapp;
use App\Models\Katpengguna;


use Illuminate\Database\Eloquent\Model;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aplikasi()
    {
        $applications = Application::all();

        // Hanya aplikasi dengan katapp Lokal atau Pusat
        $filteredApps = Application::whereHas('katapp', function ($q) {
            $q->whereIn('kategori_aplikasi', ['Lokal', 'Pusat']);
        })->get();

         // Hitung total, aktif, dan nonaktif hanya dari yang Lokal atau Pusat
        $total = $filteredApps->count();
        $aktif = $filteredApps->where('status', 1)->count();
        $nonaktif = $filteredApps->where('status', 0)->count();

        // Hanya aplikasi dengan katapp Desa
        $filteredAppsDesa = Application::whereHas('katapp', function ($q) {
            $q->whereIn('kategori_aplikasi', ['Desa']);
        })->get();

        // Hitung total, aktif, dan nonaktif hanya dari yang Desa
        $totalDesa = $filteredAppsDesa->count();
        $aktifDesa = $filteredAppsDesa->where('status', 1)->count();
        $nonaktifDesa = $filteredAppsDesa->where('status', 0)->count();

        // Hanya aplikasi dengan katapp Lainnya
        $filteredAppsLainnya = Application::whereHas('katapp', function ($q) {
            $q->whereIn('kategori_aplikasi', ['Lainnya']);
        })->get();

        // Hitung total, aktif, dan nonaktif hanya dari yang Lainnya
        $totalLainnya = $filteredAppsLainnya->count();
        $aktifLainnya = $filteredAppsLainnya->where('status', 1)->count();
        $nonaktifLainnya = $filteredAppsLainnya->where('status', 0)->count();

        $opds = Opd::withCount([
            'applications as lokal_count' => function ($query) {
                $query->whereHas('katapp', function ($q) {
                    $q->where('kategori_aplikasi', 'Lokal');
                });
            },
            'applications as pusat_count' => function ($query) {
                $query->whereHas('katapp', function ($q) {
                    $q->where('kategori_aplikasi', 'Pusat');
                });
            },
            'applications as desa_count' => function ($query) {
                $query->whereHas('katapp', function ($q) {
                    $q->where('kategori_aplikasi', 'Desa');
                });
            },
            'applications as lainnya_count' => function ($query) {
                $query->whereHas('katapp', function ($q) {
                    $q->where('kategori_aplikasi', 'Lainnya');
                });
            },
            'applications as aktif_count' => function ($query) {
                $query->where('status', 1)->whereHas('katapp', function ($q) {
                    $q->whereIn('kategori_aplikasi', ['Lokal', 'Pusat']);
                });
            },
            'applications as nonaktif_count' => function ($query) {
                $query->where('status', 0)->whereHas('katapp', function ($q) {
                    $q->whereIn('kategori_aplikasi', ['Lokal', 'Pusat']);
                });
            }
        ])->get();

        //get layanan app counts
        $layananCounts = Layananapp::withCount(['applications'])->get()->map(function ($layanan) {
            return [
                'nama' => $layanan->layanan_app,
                'jumlah' => $layanan->applications_count,
            ];
        });

        //get kategori app counts
        $kategoriAppCounts = Katapp::withCount(['applications'])->get()->map(function ($katapp) {
            return [
                'nama' => $katapp->kategori_aplikasi,
                'jumlah' => $katapp->applications_count,
            ];
        });

        //get kategori pengguna counts
        $kategoriPenggunaCounts = Katpengguna::withCount(['applications'])->get()->map(function ($item) {
            return [
                'nama' => $item->kategori_pengguna,
                'jumlah' => $item->applications_count,
            ];
        });

        //get jaringan intra counts
        $jaringanCounts = Application::select('jaringan_intra')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('jaringan_intra')
            ->get()
            ->map(function ($item) {
            return [
                'nama' => match ($item->jaringan_intra) {
                    '1' => 'Internet',
                    '2' => 'Intranet',
                    default => 'Tidak Diketahui',
                },
                'jumlah' => $item->jumlah,
            ];
        });

        // mapping year lenght for 10 years
        $years = range(now()->year - 9, now()->year);
        // Get yearly statistics
        $yearlyData = collect($years)->map(function ($year) {
            return [
                'tahun' => $year,
                'semua' => Application::where('tahun_buat', $year)->count(),

                'lokal' => Application::where('tahun_buat', $year)
                    ->whereHas('katapp', fn($q) => $q->where('kategori_aplikasi', 'Lokal'))
                    ->count(),

                'pusat' => Application::where('tahun_buat', $year)
                    ->whereHas('katapp', fn($q) => $q->where('kategori_aplikasi', 'Pusat'))
                    ->count(),

                'aktif' => Application::where('tahun_buat', $year)
                    ->where('status', 1)
                    ->count(),

                'nonaktif' => Application::where('tahun_buat', $year)
                    ->where('status', 0)
                    ->count(),
            ];
        });

        // Return the view with the data
        return view('dashboard.aplikasi.d-app', compact(
            'applications', 'opds', 'total', 'aktif', 'nonaktif', 'totalDesa', 'aktifDesa', 'nonaktifDesa', 'totalLainnya', 'aktifLainnya', 'nonaktifLainnya',
            'layananCounts', 'kategoriAppCounts', 'kategoriPenggunaCounts', 'jaringanCounts',
            'yearlyData'
        ), [
            'title' => 'Dashboard Aplikasi',
        ]);
    }

    public function spbe()
    {
        return view('dashboard.spbe.d-spbe', [
            'title' => 'Dashboard SPBE'
        ]);
    }
}
