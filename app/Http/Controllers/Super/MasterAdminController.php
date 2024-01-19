<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class MasterAdminController extends Controller
{
    public function index()
    {
        return view("super.admin.index", [
            "users" => User::where("role", "admin")->get(),
            "nomor" => 1
        ]);
    }

    public function create()
    {
        return view("super.admin.create");
    }
    
    public function store(AdminRequest $request){
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "email_verified_at" => now(),
            "role" => "admin",
            'password' => Hash::make("p4ssw0rd"),
            'remember_token' => Str::random(10),
        ]);
        return redirect()->to(route("super.admin"))->with("sukses", "Admin Baru Berhasil Ditambahkan");
    }

    public function edit($id = "")
    {
        return view("super.admin.edit", [
            "user" => User::find($id)
        ]);
    }

    public function update(AdminRequest $request, $id)
    {
        User::find($id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);
        return redirect()->to(route("super.admin"))->with("sukses", "Data Admin Berhasil Diubah");
    }

    public function destroy($id){
        try {
            User::find($id)->delete();
            return redirect()->to(route('super.admin'))->with('sukses', "Data Admin Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('super.admin'))->with('gagal', "Data Admin Gagal Dihapus");
        }
    }
}
