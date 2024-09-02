<?php

namespace App\Http\Controllers;

use App\Models\Bantuan;
use Illuminate\Http\Request;
use App\Models\DetailBantuan;


class BantuanController extends Controller
{
    public function index()
    {
        $bantuan = Bantuan::all();
        return view('admin.pages.data-bantuan', [
            'bantuan' => $bantuan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama bantuan harus diisi',
        ]);

        $bantuan = new Bantuan();
        $bantuan->name = $request->name;
        $bantuan->save();

        return redirect()->back()->with('store', 'Data bantuan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama bantuan harus diisi',
        ]);

        $bantuan = Bantuan::find($id);
        $bantuan->name = $request->name;
        $bantuan->save();

        return redirect()->back()->with('update', 'Data bantuan berhasil diubah');
    }

    public function destroy($id)
    {
        $cek_detail_bantuan = DetailBantuan::where('id_bantuan', $id)->count();

        if ($cek_detail_bantuan > 0) {
            return redirect()->back()->with('adarelasi', 'Data bantuan gagal dihapus');
        }

        $bantuan = Bantuan::find($id);
        $bantuan->delete();

        return redirect()->back()->with('destroy', 'Data bantuan berhasil dihapus');
    }
}
