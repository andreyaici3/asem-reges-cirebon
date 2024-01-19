<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VendorRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth::user()->role == "gudang")
            return true;

        return false;
    }

    public function rules()
    {
        return [
            "name" => "required|min:5",
            "phone" => "required"
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Vendor',
            "address" => "Alamat Vendor",
            "phone" => "Telp Vendor"
        ];
    }
}
