<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\ProductMerk;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeProdukController extends Controller
{
    public function index($id_merk)
    {
        @$chief_id = Auth::user()->branch->id;
        if (@$chief_id == null) {
            $type_produk = ProductType::where("product_merk_id", $id_merk)->get();
        } else {
            $type_produk = ProductType::where([
                ["chief_id", "=", $chief_id],
                ["product_merk_id", "=", $id_merk]
            ])->get();
        }
        return view("gudang.produk.type.index", [
            "types" => $type_produk,
            "merk" => ProductMerk::find($id_merk),
            "nomor"=> 1,
        ]);
    }

    public function create($id_merk)
    {
        return view("gudang.produk.type.create", [
            "merk" => ProductMerk::find($id_merk)
        ]);
    }

    public function store(Request $request, $id_merk)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            ProductType::create([
                "name"     => $request->name,
                "product_merk_id" => $id_merk
            ]);
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('sukses', "Data Type Produk Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('gagal', "Data Type Produk Gagal Ditambahkan");
        }
    }

    public function edit($id_merk,$id_type)
    {
        return view("gudang.produk.type.edit", [
            "type" => ProductType::find($id_type),
            "merk" => ProductMerk::find($id_merk),
        ]);
    }

    public function update(Request $request, $id_merk, $id_type)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            ProductType::find($id_type)->update([
                "name"     => $request->name,
            ]);
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('sukses', "Data Type Produk Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('gagal', "Data Type Produk Gagal Diubah");
        }
    }

    public function destroy($id_merk, $id_type)
    {
        try {
            ProductType::find($id_type)->delete();
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('sukses', "Data Type Produk Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.produk.type', ["id_merk" => $id_merk]))->with('gagal', "Data Type Produk Gagal Diubah");
        }
    }
}
