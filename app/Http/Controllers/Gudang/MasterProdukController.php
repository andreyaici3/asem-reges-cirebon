<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\AvailableProduct;
use App\Models\CarType;
use App\Models\MasterProduk;
use App\Models\ProductType;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

class MasterProdukController extends Controller
{
    public function index()
    {
        @$chief_id = Auth::user()->branch->id;
        if (@$chief_id == null) {
            $master = MasterProduk::get();
        } else {
            $master = MasterProduk::where([
                ["chief_id", "=", $chief_id],
            ])->get();
        }
        return view("gudang.produk.master.index", [
            "masters" => $master,
            "nomor" => 1,
        ]);
    }

    public function create()
    {

        $kode_produk =  $this->getRandomCode(13);
        return view('gudang.produk.master.create', [
            "kode" => $kode_produk,
            "car" => CarType::get(),
            "type" => ProductType::get(),
            "vendor" => Vendor::get(),
        ]);
    }

    private function getRandomCode($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(ProductRequest $request)
    {
        @$chief_id = Auth::user()->branch->id;
        if (@$chief_id != null) {
            try {
                $file = $request->file('gambar');
                $name = $file->hashName();


                MasterProduk::create([
                    "chief_id" => $chief_id,
                    "code" => $request->code,
                    "name" => $request->name,
                    "price" => $request->price,
                    "selling" => $request->selling,
                    "product_type_id" => $request->product_type,
                    "vendor_id" => $request->vendor,
                    "stok" => $request->stok,
                    "gambar" => $name,
                    "garansi" => $request->garansi ?? null,
                    "discount" => $request->discount ?? 0,
                ]);

                if ($request->available != null) {
                    foreach ($request->available as $value) {
                        AvailableProduct::create([
                            "product_master_code" => $request->code,
                            "car_type_id" => $value,
                        ]);
                    }
                }
                $file->storeAs('public/images', $name);
                return redirect()->to(route('gudang.produk.master'))->with('sukses', "Data Master Produk Berhasil Ditambahkan");
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->to(route('gudang.produk.master'))->with('gagal', "Data Master Produk Gagal Ditambahkan");
            }
        } else {
            return redirect()->to(route('gudang.produk.master'))->with('gagal', "Data Master Produk Gagal Ditambahkan");
        }
    }

    public function edit($id)
    {
        $master = MasterProduk::find($id);

        return view('gudang.produk.master.edit', [
            "car" => CarType::get(),
            "type" => ProductType::get(),
            "product" => $master,
            "kode" => $master->code,
            "vendor" => Vendor::get(),
        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        @$chief_id = Auth::user()->branch->id;
        if (@$chief_id != null) {

            //cek ada file yang di upload
            $file = $request->file('gambar');
            $prd = MasterProduk::find($id);
            try {
                if (@$file->hashName() != null) {
                    if (Storage::disk('public')->exists('images/' . $prd->gambar)) {
                        Storage::disk('public')->delete('images/' . $prd->gambar);
                    }
                    $name = $file->hashName();
                    $file->storeAs('public/images', $name);
                }
            } catch (\Throwable $th) {
                $name = $prd->gambar;
            }

            MasterProduk::find($id)->update([
                "name" => $request->name,
                "price" => $request->price,
                "selling" => $request->selling,
                "product_type_id" => $request->product_type,
                "vendor_id" => $request->vendor,
                "stok" => $request->stok,
                "gambar" => $name,
                "garansi" => $request->garansi ?? null,
                "discount" => $request->discount ?? 0,
            ]);

            AvailableProduct::where('product_master_code', $request->code)->delete();

            if ($request->available != null) {
                foreach ($request->available as $value) {
                    AvailableProduct::create([
                        "product_master_code" => $request->code,
                        "car_type_id" => $value,
                    ]);
                }
            }
            return redirect()->to(route('gudang.produk.master'))->with('sukses', "Data Master Produk Berhasil Diubah");
        } else {
            return redirect()->to(route('gudang.produk.master'))->with('gagal', "Data Master Produk Gagal Diubah");
        }
    }

    public function destroy($id)
    {
        try {
            $produk = MasterProduk::find($id);
            AvailableProduct::where('product_master_code', $produk->code)->delete();
            if (Storage::disk('public')->exists('images/' . $produk->gambar)) {
                Storage::disk('public')->delete('images/' . $produk->gambar);
            }
            $produk->delete();
            return redirect()->to(route('gudang.produk.master'))->with('sukses', "Data Master Produk Berhasil DiHapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('gudang.produk.master'))->with('gagal', "Data Master Produk Gagal DiHapus");
        }
    }

    public function generate_barcode($kode_produk)
    {
        return view('gudang.produk.master.generate', [
            "product" => MasterProduk::where('code', $kode_produk)->first(),
        ]);
    }
}
