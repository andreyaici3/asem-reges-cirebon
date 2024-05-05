<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\CarMerk;
use App\Models\CarType;
use Illuminate\Http\Request;

class TypeMobilController extends Controller
{
    public function index($id)
    {
        return view("gudang.mobil.type.index", [
            "nomor" => 1,
            "merk" => CarMerk::find($id),
            "types" => CarType::where('merk_id', $id)->get(),
        ]);
    }

    public function create($id)
    {
        return view("gudang.mobil.type.create", [
            "merk" => CarMerk::find($id)
        ]);
    }

    public function store(Request $request, $id_merk)
    {
        $ress =  count($request->jenis ?? []);
        if ($ress == 0)
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('gagal', "Tidak Ada Data Yang Dimasukan");

        try {
            for ($i = 0; $i < count($request->jenis); $i++) {
                CarType::create([
                    "merk_id" => $id_merk,
                    "jenis" => $request->jenis[$i],
                    "tipe" => $request->tipe[$i],
                    "tahun" => $request->tahun[$i],
                ]);
            }

            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('sukses', "Data type Mobil Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('gagal', "Data type Mobil Gagal Ditambahkan");
        }
    }

    public function edit($id_type, $id_merk)
    {
        return view("gudang.mobil.type.edit", [
            "type" => CarType::find($id_type),
            "merk" => CarMerk::find($id_merk,)
        ]);
    }

    public function update(Request $request, $id_type, $id_merk)
    {
        try {
            CarType::find($id_type)->update([
                "jenis" => $request->jenis,
                "tipe" => $request->tipe ?? null,
                "tahun" => $request->tahun ?? null,
            ]);
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('sukses', "Data Type Mobil Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('gagal', "Data Type Mobil Gagal Diubah");
        }
    }

    public function destroy($id_type, $id_merk)
    {
        try {
            CarType::find($id_type)->delete();
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('sukses', "Data Type Mobil Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.mobil.type', ["id_merk" => $id_merk]))->with('gagal', "Data Type Mobil Gagal Dihapus");
        }
    }
}
