<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view("admin.layanan.index", [
            "services" => Service::orderBy("id", "desc")->take(100)->get(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            Service::create([
                "service_name" => $request->name,
            ]);
            return redirect()->to(route("layanan"))->with('sukses', "Data Layanan Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("layanan"))->with('gagal', "Data Layanan Gagal Ditambahkan");
        }
    }
    
    public function destroy($id)
    {
        try {
            Service::find($id)->delete();
            return redirect()->to(route("layanan"))->with('sukses', "Data Layanan Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("layanan"))->with('gagal', "Data Layanan Gagal Dihapus");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Service::find($id)->update([
                "service_name" => $request->name
            ]);
            return redirect()->to(route("layanan"))->with('sukses', "Data Layanan Berhasil DiUbah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("layanan"))->with('gagal', "Data Layanan Gagal DiUbah");
        }
    }
}
