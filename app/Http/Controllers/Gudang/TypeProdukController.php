<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\ProductMerk;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeProdukController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subName' => 'required',
        ]);

        try {
            ProductType::create([
                "name"     => $request->subName,
                "product_merk_id" => $request->product_merk_id
            ]);
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Sub Merk ($request->subName) Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Sub Merk ($request->subName) Gagal Ditambahkan");
        }
    }

    public function update(Request $request, $id_merk, $id_type)
    {
        $request->validate([
            'subName' => 'required',
        ]);

        try {
            ProductType::find($id_type)->update([
                "name"     => $request->subName,
            ]);
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Type Produk Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Type Produk Gagal Diubah");
        }
    }

    public function destroy($id_merk, $id_type)
    {
        try {
            ProductType::find($id_type)->delete();
            return redirect()->to(route('admin.produk.merk'))->with('sukses', "Data Type Produk Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.produk.merk'))->with('gagal', "Data Type Produk Gagal Dihapus");
        }
    }
}
