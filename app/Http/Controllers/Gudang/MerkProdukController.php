<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\ProductMerk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerkProdukController extends Controller
{
    public function index()
    {
        return view("admin.master.merk.index", [
            "nomor" => 1,
            "merks" => ProductMerk::get(),
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        @$chief_id = Auth::user()->branch->branch_id;

        try {
            ProductMerk::create([
                "chief_id" => $chief_id,
                "name"     => $request->name,
            ]);
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Merk Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Merk Gagal Ditambahkan");
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
        ]);

        try {
            ProductMerk::find($id)->update([
                "name"     => $request->name,
            ]);
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Merk Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Merk Gagal Diubah");
        }
    }

    public function destroy($id){
       
        try {
            ProductMerk::find($id)->delete();
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Merk Berhasil Di Hapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Merk Gagal Di Hapus");
        }
    }

    public function get_data_by_id($id){
        return ProductMerk::find($id)->type;
    }

}
