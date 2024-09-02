<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Bantuan;
use App\Models\DetailBantuan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PenghitunganController extends Controller
{
    public function indexhasil()
    {

        $jumlah_data_kriteria = Kriteria::count();
        $jumlah_data_sub_kriteria = SubKriteria::count();

        if ($jumlah_data_kriteria == 0 || $jumlah_data_sub_kriteria == 0) {
            return redirect('/dashboard')->with('dataerror', 'Data kriteria atau sub kriteria belum lengkap, silahkan lengkapi data kriteria dan sub kriteria terlebih dahulu');
        }

        // Mengambil data anak, kriteria, dan sub kriteria
        $anak_list = Anak::with('detailAnak')->get();
        $kriteria_list = Kriteria::all();
        $sub_kriteria_list = SubKriteria::all();

        $nilai_maks = [];
        $nilai_min = [];
        $data_alternatif = [];
        $data_normalisasi = [];

        // Menentukan data alternatif dan bobotnya
        foreach ($anak_list as $anak) {
            $data_alternatif[$anak->id] = [];
            foreach ($anak->detailAnak as $detail) {
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();
                $data_alternatif[$anak->id][$detail->id_kriteria] = $sub_kriteria->bobot; // Asumsikan bobot diambil dari sub_kriteria
            }
        }

        // Menentukan nilai maksimum dan minimum untuk setiap kriteria
        foreach ($kriteria_list as $kriteria) {
            $nilai_kriteria = array_column($data_alternatif, $kriteria->id);
            $nilai_maks[$kriteria->id] = max($nilai_kriteria);
            $nilai_min[$kriteria->id] = min($nilai_kriteria);
        }

        // Normalisasi data alternatif
        foreach ($anak_list as $anak) {
            $data_normalisasi[$anak->id] = [];
            foreach ($anak->detailAnak as $detail) {
                $kriteria = $kriteria_list->where('id', $detail->id_kriteria)->first();
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();

                if ($kriteria->jenis == 'benefit') {
                    $data_normalisasi[$anak->id][$detail->id_kriteria] = ($sub_kriteria->bobot / $nilai_maks[$detail->id_kriteria]) * $kriteria->bobot;
                } else {
                    $data_normalisasi[$anak->id][$detail->id_kriteria] = ($nilai_min[$detail->id_kriteria] / $sub_kriteria->bobot) * $kriteria->bobot;
                }
            }
        }

        // Menghitung nilai akhir dan klasifikasi
        $data_akhir = [];
        $threshold = 70; // Threshold untuk klasifikasi

        foreach ($anak_list as $anak) {
            $data_akhir[$anak->id] = [];
            $data_akhir[$anak->id]['nama_anak'] = $anak->name;
            $data_akhir[$anak->id]['nama_ibu'] = $anak->name_ibu;

            // Menampilkan kriteria dan subkriteria anak
            $data_akhir[$anak->id]['kriteria'] = [];
            foreach ($anak->detailAnak as $detail) {
                $kriteria = $kriteria_list->where('id', $detail->id_kriteria)->first();
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();
                $data_akhir[$anak->id]['kriteria'][$kriteria->name] = $sub_kriteria->name;
            }

            // Menghitung nilai akhir dari normalisasi
            $nilai_akhir = array_sum($data_normalisasi[$anak->id]);
            $data_akhir[$anak->id]['nilai_akhir'] = $nilai_akhir;
            $data_akhir[$anak->id]['id_anak'] = $anak->id;

            // Menentukan klasifikasi berdasarkan nilai akhir
            $data_akhir[$anak->id]['klasifikasi'] = $nilai_akhir >= $threshold ? 'Tidak Berpotensi Stunting' : 'Berpotensi Stunting';
        }

        $bantuan = Bantuan::all();

        return view('admin.pages.data-penghitungan-hasil', [
            'data_akhir' => $data_akhir,
            'bantuan' => $bantuan,
        ]);
    }


    public function indexdetail()
    {

        $jumlah_data_kriteria = Kriteria::count();
        $jumlah_data_sub_kriteria = SubKriteria::count();

        if ($jumlah_data_kriteria == 0 || $jumlah_data_sub_kriteria == 0) {
            return redirect('/dashboard')->with('dataerror', 'Data kriteria atau sub kriteria belum lengkap, silahkan lengkapi data kriteria dan sub kriteria terlebih dahulu');
        }


        // Mengambil data anak, kriteria, dan sub kriteria
        $anak_list = Anak::with('detailAnak')->get();
        $kriteria_list = Kriteria::all();
        $sub_kriteria_list = SubKriteria::all();

        $nilai_maks = [];
        $nilai_min = [];
        $data_alternatif_tampil = [];
        $data_normalisasi = [];

        // Menentukan data alternatif dan bobotnya
        foreach ($anak_list as $anak) {
            $data_alternatif_tampil[$anak->id] = [];
            foreach ($anak->detailAnak as $detail) {
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();
                $data_alternatif_tampil[$anak->id][$detail->id_kriteria] = $sub_kriteria->bobot;
            }
        }

        // Menentukan nilai maksimum dan minimum untuk normalisasi
        foreach ($kriteria_list as $kriteria) {
            $nilai_kriteria = array_column($data_alternatif_tampil, $kriteria->id);
            $nilai_maks[$kriteria->id] = max($nilai_kriteria);
            $nilai_min[$kriteria->id] = min($nilai_kriteria);
        }

        // Normalisasi data alternatif
        foreach ($anak_list as $anak) {
            $data_normalisasi[$anak->id] = [];
            foreach ($anak->detailAnak as $detail) {
                $kriteria = $kriteria_list->where('id', $detail->id_kriteria)->first();
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();
                if ($kriteria->jenis == 'benefit') {
                    $data_normalisasi[$anak->id][$detail->id_kriteria] = $sub_kriteria->bobot / $nilai_maks[$detail->id_kriteria] * $kriteria->bobot;
                } else {
                    $data_normalisasi[$anak->id][$detail->id_kriteria] = $nilai_min[$detail->id_kriteria] / $sub_kriteria->bobot * $kriteria->bobot;
                }
            }
        }

        // Siapkan data untuk ditampilkan di view
        $tampil_normalisasi = [];
        foreach ($anak_list as $anak) {
            $tampil_normalisasi[$anak->id]['anak'] = $anak->name;
            $tampil_normalisasi[$anak->id]['data'] = $data_normalisasi[$anak->id];
        }

        // Menentukan hasil akhir dan klasifikasi
        $data_akhir = [];
        $threshold = 70; // Threshold normalisasi 70
        foreach ($anak_list as $anak) {
            $data_akhir[$anak->id] = [];
            $data_akhir[$anak->id]['nama_anak'] = $anak->name;
            $data_akhir[$anak->id]['nama_ibu'] = $anak->name_ibu;

            // Menampilkan kriteria dan subkriteria anak
            $data_akhir[$anak->id]['kriteria'] = [];
            foreach ($anak->detailAnak as $detail) {
                $kriteria = $kriteria_list->where('id', $detail->id_kriteria)->first();
                $sub_kriteria = $sub_kriteria_list->where('id', $detail->id_sub_kriteria)->first();
                $data_akhir[$anak->id]['kriteria'][$kriteria->name] = $sub_kriteria->name;
            }

            $nilai_akhir = array_sum($data_normalisasi[$anak->id]); // Menghitung nilai akhir
            $data_akhir[$anak->id]['nilai_akhir'] = $nilai_akhir;
            $data_akhir[$anak->id]['klasifikasi'] = $nilai_akhir > $threshold ? 'Tidak Berpotensi Stunting' : 'Berpotensi Stunting';
        }

        return view('admin.pages.data-penghitungan-detail', [
            'anak_list' => $anak_list,
            'kriteria_list' => $kriteria_list,
            'kriteria' => $kriteria_list,
            'data_alternatif' => $data_alternatif_tampil,
            'data_tampil_normalisasi' => $tampil_normalisasi,
            'data_akhir' => $data_akhir,
        ]);
    }

    public function storebantuan(Request $request)
    {
        $request->validate([
            'id_anak' => 'required',
            'id_bantuan' => 'required',
            'jumlah' => 'required',
        ], [
            'id_anak.required' => 'Anak harus dipilih',
            'id_bantuan.required' => 'Bantuan harus dipilih',
            'jumlah.required' => 'Jumlah bantuan harus diisi',
        ]);

        $DetailBantuan = new DetailBantuan();
        $DetailBantuan->id_anak = $request->id_anak;
        $DetailBantuan->id_bantuan = $request->id_bantuan;
        $DetailBantuan->jumlah = $request->jumlah;
        $DetailBantuan->save();

        return redirect()->back()->with('store', 'Data bantuan berhasil disimpan');
    }

    public function updatebantuan(Request $request, $id)
    {
        $request->validate([
            'id_bantuan' => 'required',
            'jumlah' => 'required',
        ], [
            'id_bantuan.required' => 'Bantuan harus dipilih',
            'jumlah.required' => 'Jumlah bantuan harus diisi',
        ]);

        $DetailBantuan = DetailBantuan::find($id);
        $DetailBantuan->id_bantuan = $request->id_bantuan;
        $DetailBantuan->jumlah = $request->jumlah;
        $DetailBantuan->save();

        return redirect()->back()->with('update', 'Data bantuan berhasil diubah');
    }

    public function destroybantuan($id)
    {
        $DetailBantuan = DetailBantuan::find($id);
        $DetailBantuan->delete();

        return redirect()->back()->with('destroy', 'Data bantuan berhasil dihapus');
    }
}
