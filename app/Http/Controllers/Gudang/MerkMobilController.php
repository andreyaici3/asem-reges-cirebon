<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\CarMerk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerkMobilController extends Controller
{
    public function index()
    {
        return view("gudang.mobil.merk.index", [
            "nomor" => 1,
            "merks" => CarMerk::get(),
        ]);
    }

    public function create()
    {
        return view("gudang.mobil.merk.create");
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        @$chief_id = Auth::user()->employe->chief_id;
        try {
            CarMerk::create([
                "chief_id" => $chief_id,
                "name"     => $request->name,
            ]);
            return redirect()->to(route('gudang.mobil.merk'))->with('sukses', "Data Merk Mobil Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.merk'))->with('gagal', "Data Merk Mobil Gagal Ditambahkan");
        }
        
    }

    public function edit($id)
    {
        return view("gudang.mobil.merk.edit", [
            "merk" => CarMerk::find($id)
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
        ]);

        try {
            CarMerk::find($id)->update([
                "name"     => $request->name,
            ]);
            return redirect()->to(route('gudang.mobil.merk'))->with('sukses', "Data Merk Mobil Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.merk'))->with('gagal', "Data Merk Mobil Gagal Diubah");
        }
    }

    public function destroy( $id){
       
        try {
            CarMerk::find($id)->delete();
            return redirect()->to(route('gudang.mobil.merk'))->with('sukses', "Data Merk Mobil Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.merk'))->with('gagal', "Data Merk Mobil Gagal Dihapus");
        }
    }

}
