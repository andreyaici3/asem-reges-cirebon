<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarMerk;
use App\Models\CarType;
use App\Models\Service;
use App\Models\SubService;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class ServiceController extends Controller
{
    public function index()
    {
        return view("admin.layanan.index", [
            "services" => Service::orderBy("id", "desc")->take(100)->get(),
            "merk" => CarMerk::get(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $service = Service::create([
                "service_name" => $request->name,
            ]);

            $type = CarType::get();
            foreach ($type as $value){
                SubService::create([
                    "service_id" => $service->id,
                    "id_type" => $value->id,
                    "harga_jasa" => 0,
                    "harga_jasa_khusus" => 0,
                ]);
            }
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

    public function createSub(Request $request, $id_layanan)
    {
        $jenis = CarMerk::findOrFail($request->merk);
        return view("admin.layanan.sub-layanan", [
            "jenis" => $jenis,
            "jenis_mobil" => $jenis->tipe,
            "layanan" => Service::findOrFail($id_layanan),
        ]);
    }

    public function storeSub(Request $request, $id_layanan)
    {
        $ress =  count($request->jenis ?? []);
        if ($ress == 0)
            return redirect()->to("")->with('gagal', "Tidak Ada Data Yang Dimasukan");

        try {
            for ($i = 0; $i < count($request->jenis); $i++) {
                SubService::create(
                    [
                        "service_id" => $id_layanan,
                        "id_type" => $request->jenis[$i],
                        "harga_jasa" => $request->jasa[$i],
                        "harga_jasa_khusus" => $request->jk[$i]
                    ]
                );
            }
            return redirect()->to(route("layanan"))->with('sukses', "Data Layanan Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("layanan"))->with('gagal', "Data Layanan Gagal Ditambahkan");
        }
    }

    public function detailSub($id_layanan)
    {
        $subLayanan = Service::findOrFail($id_layanan);
        return view("admin.layanan.detail-sub-layanan", [
            "subs" => $subLayanan
        ]);
    }

    public function saveAllSub(Request $request, $id_layanan){
        foreach ($request->harga_jasa as $key => $value){
            SubService::find($key)->update([
                "harga_jasa" => $request->harga_jasa[$key],
                "harga_jasa_khusus" => $request->harga_jasa_khusus[$key]
            ]);
        }
        return redirect()->to(route("sublayanan", ["id_layanan" => $id_layanan]))->with('sukses', "Data Layanan Berhasil Disimpan");
    }
}
