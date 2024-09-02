<?php

namespace App\Http\Controllers;

use App\Models\DetailAnak;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('admin.pages.data-kriteria', [
            'kriteria' => $kriteria
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
        ], [
            'name.required' => 'Nama Kriteria harus diisi',
            'bobot.required' => 'Bobot Kriteria harus diisi',
            'jenis.required' => 'Jenis Kriteria harus diisi',
        ]);

        $kriteria = new Kriteria();
        $kriteria->name = $request->name;
        $kriteria->bobot = $request->bobot;
        $kriteria->jenis = $request->jenis;
        $kriteria->save();

        return redirect()->back()->with('store', 'Data Kriteria berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'bobot' => 'required',
            'jenis' => 'required',
        ], [
            'name.required' => 'Nama Kriteria harus diisi',
            'bobot.required' => 'Bobot Kriteria harus diisi',
            'jenis.required' => 'Jenis Kriteria harus diisi',
        ]);

        $kriteria = Kriteria::find($id);
        $kriteria->name = $request->name;
        $kriteria->bobot = $request->bobot;
        $kriteria->jenis = $request->jenis;
        $kriteria->save();

        return redirect()->back()->with('update', 'Data Kriteria berhasil diubah');
    }

    public function destroy($id)
    {

        $cek_kriteria = DetailAnak::where('id_kriteria', $id)->count();
        if ($cek_kriteria > 0) {
            return redirect()->back()->with('adarelasi', 'Data Kriteria gagal dihapus, karena data masih digunakan');
        }

        $kriteria = Kriteria::find($id);
        $kriteria->delete();

        return redirect()->back()->with('destroy', 'Data Kriteria berhasil dihapus');
    }
}
