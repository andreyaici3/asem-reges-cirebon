<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index()
    {
        return view("gudang.vendor.index", [
            "vendors" => Vendor::get(),
            "nomor" => 1,
        ]);
    }

    public function create()
    {        
        return view("gudang.vendor.create");
    }

    public function store(VendorRequest $request)
    {
        @$chief_id = Auth::user()->employe->chief_id;
        try {
            Vendor::create([
                "chief_id" => $chief_id,
                "name"     => $request->name,
                "address" => $request->address,
                "phone" => $request->phone,
            ]);
            return redirect()->to(route('gudang.vendor'))->with('sukses', "Data Vendor Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.vendor'))->with('gagal', "Data Vendor Gagal Ditambahkan");
        }
    }

    public function edit($id)
    {        
        return view("gudang.vendor.edit", [
            "vendor" => Vendor::find($id)
        ]);
    }

    public function update(VendorRequest $request, $id){
        try {
            Vendor::find($id)->update([
                "name"     => $request->name,
                "address" => $request->address,
                "phone" => $request->phone,
            ]);
            return redirect()->to(route('gudang.vendor'))->with('sukses', "Data Vendor Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.vendor'))->with('gagal', "Data Vendor Gagal Diubah");
        }
    }

    public function destroy($id){
        try {
            Vendor::find($id)->delete();
            return redirect()->to(route('gudang.vendor'))->with('sukses', "Data Vendor Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.vendor'))->with('gagal', "Data Vendor Gagal Dihapus");
        }
    }
}
