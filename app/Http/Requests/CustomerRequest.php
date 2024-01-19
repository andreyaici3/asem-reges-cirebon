<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth::user()->role == "superadmin" || Auth::user()->role == "superuser" || Auth::user()->role == "mekanik")
            return true;

        return false;
    }

    public function rules(): array
    {
        return [
            'tipe' => ['required'],
            'name' => ['required'],
            'number_plat' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'tipe.required' => 'Tipe Mobil Tidak Boleh Kosong',
            'name.required' => 'Nama Tidak Boleh Kosong',
            'number_plat.required' => 'Plat Nomor Tidak Boleh Kosong',
        ];
    }
}
