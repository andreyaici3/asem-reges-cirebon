<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ChiefBranch;
use App\Models\User;
use Illuminate\Http\Request;

class MappingKepalaController extends Controller
{
    public function index()
    {
        return view("super.kepala.index", [
            "chiefs" => ChiefBranch::get(),
            "nomor" => 1
        ]);
    }

    public function create()
    {
        return view("super.kepala.create", [
            "admin" => User::where('role', "admin")->get(),
            "branch" => Branch::get(),
        ]);
    }

    public function store(Request $request)
    {
        try {
            ChiefBranch::create($request->all());
            return redirect()->to(route("super.kepala"))->with("sukses", "Kepala Berhasil Di Map");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("super.kepala"))->with("gagal", "Kepala Gagal Di Map");
        }
    }

    public function edit($id)
    {
        return view("super.kepala.edit", [
            "maping" => ChiefBranch::find($id),
            "admin" => User::where('role', "admin")->get(),
            "branch" => Branch::get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            ChiefBranch::find($id)->update($request->all());
            return redirect()->to(route("super.kepala"))->with("sukses", "Kepala / Cabang Berhasil Di Ubah");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("super.kepala"))->with("gagal", "Kepala / Cabang Gagal Di Ubah");
        }
    }

    public function destroy($id)
    {
        try {
            ChiefBranch::find($id)->delete();
            return redirect()->to(route("super.kepala"))->with("sukses", "Mapping berhasil dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("super.kepala"))->with("gagal", "Mapping gagal dihapus");
        }
    }
}
