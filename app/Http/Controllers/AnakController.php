<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Bantuan;
use App\Models\Kriteria;
use App\Models\DetailAnak;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    public function index()
    {
        $bantuan = Bantuan::all();
        $kriteria = Kriteria::all();
        $anak = Anak::with('detailAnak')->get();
        return view('admin.pages.data-anak', [
            'anak' => $anak,
            'kriteria' => $kriteria,
            'bantuan' => $bantuan
        ]);
    }

    public function store(Request $request)
    {
        $cek_kriteria = Kriteria::count();
        $cek_sub_kriteria = SubKriteria::count();

        if ($cek_kriteria == 0 || $cek_sub_kriteria == 0) {
            return redirect()->back()->with('isidulukriteriadansubkriteria', 'Data Kriteria dan Sub Kriteria harus diisi terlebih dahulu');
        }
        // Validasi input
        $request->validate([
            'name' => 'required',
            'name_ibu' => 'required',
            'kriteria.*' => 'required' // pastikan semua kriteria dipilih
        ], [
            'name.required' => 'Nama Anak harus diisi',
            'name_ibu.required' => 'Nama Ibu harus diisi',
            'kriteria.*.required' => 'Sub kriteria harus dipilih untuk setiap kriteria'
        ]);

        // Simpan data anak
        $anak = new Anak();
        $anak->name = $request->name;
        $anak->name_ibu = $request->name_ibu;
        $anak->save(); // Simpan data anak terlebih dahulu

        // Simpan detail anak berdasarkan kriteria dan sub kriteria yang dipilih
        foreach ($request->kriteria as $id_kriteria => $id_sub_kriteria) {
            $detailAnak = new DetailAnak();
            $detailAnak->id_anak = $anak->id;
            $detailAnak->id_kriteria = $id_kriteria;
            $detailAnak->id_sub_kriteria = $id_sub_kriteria;
            $detailAnak->save();
        }

        return redirect()->back()->with('store', 'Data Anak berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'name_ibu' => 'required',
            'kriteria.*' => 'required' // pastikan setiap kriteria memiliki sub kriteria yang dipilih
        ], [
            'name.required' => 'Nama Anak harus diisi',
            'name_ibu.required' => 'Nama Ibu harus diisi',
            'kriteria.*.required' => 'Sub kriteria harus dipilih untuk setiap kriteria'
        ]);

        // Update data anak
        $anak = Anak::find($id);
        $anak->name = $request->name;
        $anak->name_ibu = $request->name_ibu;
        $anak->save();

        // Update atau insert detail anak
        foreach ($request->kriteria as $id_kriteria => $id_sub_kriteria) {
            // Cek jika detail anak sudah ada
            $detailAnak = DetailAnak::where('id_anak', $anak->id)
                ->where('id_kriteria', $id_kriteria)
                ->first();

            if ($detailAnak) {
                // Jika ada, update
                $detailAnak->id_sub_kriteria = $id_sub_kriteria;
                $detailAnak->save();
            } else {
                // Jika tidak ada, buat baru
                $detailAnak = new DetailAnak();
                $detailAnak->id_anak = $anak->id;
                $detailAnak->id_kriteria = $id_kriteria;
                $detailAnak->id_sub_kriteria = $id_sub_kriteria;
                $detailAnak->save();
            }
        }

        return redirect()->back()->with('update', 'Data Anak berhasil diubah');
    }


    public function destroy($id)
    {
        $cek_anak_detail = DetailAnak::where('id_anak', $id)->get();
        foreach ($cek_anak_detail as $item) {
            $item->delete();
        }

        $anak = Anak::find($id);
        $anak->delete();

        return redirect()->back()->with('destroy', 'Data Anak berhasil dihapus');
    }
}
