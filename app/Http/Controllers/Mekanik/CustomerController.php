<?php

namespace App\Http\Controllers\Mekanik;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\CarType;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return view("mekanik.pelanggan.index", [
           "nomor" => 1,
           "customers" => Customer::get(),
        ]);
    }

    public function create()
    {
        return view("mekanik.pelanggan.create", [
            "cars" => CarType::get(),
        ]);
    }

    public function store(CustomerRequest $request)
    {
        @$chief_id = Auth::user()->employe->chief_id;
        try {
            Customer::create([
                "chief_id" => $chief_id,
                "car_type_id" => $request->tipe,
                "name" => $request->name,
                "number_plat" => $request->number_plat
            ]);
            return redirect()->to(route('mekanik.pelanggan'))->with('sukses', "Data Pelanggan Berhasil Ditambahkan");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('mekanik.pelanggan'))->with('gagal', "Data Pelanggan Gagal Ditambahkan");
        }
    }

    public function edit($id)
    {
        return view("mekanik.pelanggan.edit", [
            "customer" => Customer::find($id),
            "cars" => CarType::get(),
        ]);
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            Customer::find($id)->update([
                "car_type_id" => $request->tipe,
                "name" => $request->name,
                "number_plat" => $request->number_plat
            ]);
            return redirect()->to(route('mekanik.pelanggan'))->with('sukses', "Data Pelanggan Berhasil Diubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('mekanik.pelanggan'))->with('gagal', "Data Pelanggan Gagal Diubah");
        }
    }


    public function destroy($id)
    {
        try {
            Customer::find($id)->delete();
            return redirect()->to(route('mekanik.pelanggan'))->with('sukses', "Data Pelanggan Berhasil DiHapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('mekanik.pelanggan'))->with('gagal', "Data Pelanggan Gagal DiHapus");
        }
    }
}
