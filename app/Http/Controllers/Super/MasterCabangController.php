<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\CabangRequest;
use App\Models\Branch;
use App\Models\ChiefBranch;
use App\Models\User;

class MasterCabangController extends Controller
{
    public function index()
    {
        return view("super.cabang.index", [
            "branches" => Branch::orderBy("name", "ASC")->get(),
            "nomor" => 1
        ]);
    }

    public function create()
    {
        return view("super.cabang.create");
    }
    
    public function store(CabangRequest $request)
    {
        $response = Branch::create($request->all());

        ChiefBranch::create([
            "branch_id" => $response->id
        ]);
        return redirect()->to(route("super.cabang"))->with("sukses", "Cabang Berhasil Ditambahkan");
    }

    public function edit($id = "")
    {
        return view("super.cabang.edit", [
            "branch" => Branch::find($id)
        ]);
    }

    public function update(CabangRequest $request, $id)
    {
        Branch::find($id)->update($request->all());
        return redirect()->to(route("super.cabang"))->with("sukses", "Cabang Berhasil Diubah");
    }

    public function destroy($id){
        try {
            Branch::find($id)->delete();
            return redirect()->to(route("super.cabang"))->with("sukses", "Cabang Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route("super.cabang"))->with("gagal", "Cabang Gagal Dihapus");
        }
    }

}
