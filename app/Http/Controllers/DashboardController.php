<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\DetailAnak;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_id_anak_di_detail_bantuan = $jumlah_id_anak_di_detail_bantuan = DB::table('tb_detail_bantuan')
            ->select('id_anak')
            ->distinct()
            ->count('id_anak');
            
        $kriteria = Kriteria::count();
        $subKriteria = SubKriteria::count();
        $anak = Anak::count();
        $user = User::count();
        return view('admin.pages.dashboard', [
            'kriteria' => $kriteria,
            'subkriteria' => $subKriteria,
            'anak' => $anak,
            'user' => $user,
            'penerima_bantuan' => $jumlah_id_anak_di_detail_bantuan
        ]);
    }
}
