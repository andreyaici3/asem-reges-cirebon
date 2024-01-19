<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CabangRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth::user()->role == "superadmin" || Auth::user()->role == "superuser")
            return true;

        return false;
    }

    public function rules()
    {
        return [
            "name" => "required|min:5",
            "address" => "required|min:20",
            "phone" => "required"
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Cabang',
            "address" => "Alamat Cabang",
            "phone" => "Telp Cabang"
        ];
    }
}
