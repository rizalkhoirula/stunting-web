<?php

namespace App\Http\Controllers;

use App\Models\DetailAnak;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;


class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        $subkriteria = SubKriteria::with('kriteria')->get();
        return view('admin.pages.data-subkriteria', [
            'subkriteria' => $subkriteria,
            'kriteria' => $kriteria,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kriteria' => 'required',
            'name' => 'required',
            'bobot' => 'required',
        ], [
            'id_kriteria.required' => 'Kriteria harus diisi',
            'name.required' => 'Nama Sub Kriteria harus diisi',
            'bobot.required' => 'Bobot harus diisi',
        ]);

        $subkriteria = new SubKriteria();
        $subkriteria->id_kriteria = $request->id_kriteria;
        $subkriteria->name = $request->name;
        $subkriteria->bobot = $request->bobot;
        $subkriteria->save();

        return redirect()->back()->with('store', 'Sub Kriteria berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kriteria' => 'required',
            'name' => 'required',
            'bobot' => 'required',
        ], [
            'id_kriteria.required' => 'Kriteria harus diisi',
            'name.required' => 'Nama Sub Kriteria harus diisi',
            'bobot.required' => 'Bobot harus diisi',
        ]);

        $subkriteria = SubKriteria::find($id);
        $subkriteria->id_kriteria = $request->id_kriteria;
        $subkriteria->name = $request->name;
        $subkriteria->bobot = $request->bobot;
        $subkriteria->save();

        return redirect()->back()->with('update', 'Sub Kriteria berhasil diubah');
    }

    public function destroy($id)
    {
        $cek_subkriteria = DetailAnak::where('id_sub_kriteria', $id)->count();
        if ($cek_subkriteria > 0) {
            return redirect()->back()->with('adarelasi', 'Sub Kriteria tidak bisa dihapus karena masih digunakan');
        }

        $subkriteria = SubKriteria::find($id);
        $subkriteria->delete();

        return redirect()->back()->with('destroy', 'Sub Kriteria berhasil dihapus');
    }
}
