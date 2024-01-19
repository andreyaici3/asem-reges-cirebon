<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index($type)
    {
        @$chief_id = Auth::user()->branch->id;
        if (@$chief_id == null){
            $users = User::where("role", $type)->get();
        } else {
            $users = User::where("role", $type)->whereHas('employe', function($q) use($chief_id){
                $q->where('employe.chief_id', '=', $chief_id);
            })->get();
        }
        
        

        if ($type == "gudang" || $type == "kasir" || $type == "mekanik"){
            return view("admin.karyawan.index", [
                "users" => $users,
                "nomor" => 1,
                "header" => strtoupper($type),
                "routes_new" => route("admin.karyawan.create", ["type" => $type]),
            ]);
        }else {
            abort(404);
        }
       
    }

    public function create($type)
    {
        if ($type == "gudang" || $type == "kasir" || $type == "mekanik"){
            return view("admin.karyawan.create", [
                "header" => strtoupper($type),
            ]);
        }else {
            abort(404);
        }
    }

    public function store(AdminRequest $request, $type){

        $response = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "email_verified_at" => now(),
            "role" => $type,
            'password' => Hash::make("p4ssw0rd"),
            'remember_token' => Str::random(10),
        ]);

        Employe::create([
            "users_id" => $response->id,
            "chief_id" => Auth::user()->branch->id,
        ]);

        return redirect()->to(route("admin.karyawan", ['type' => $type]))->with("sukses", "$type Baru Berhasil Ditambahkan");
    }
    
    public function destroy($type, $id){
        try {
            User::find($id)->delete();
            return redirect()->to(route('admin.karyawan', ['type' => $type]))->with('sukses', "Data $type Berhasil Dihapus");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->to(route('admin.karyawan', ['type' => $type]))->with('gagal', "Data $type Gagal Dihapus");
        }
    }
}
