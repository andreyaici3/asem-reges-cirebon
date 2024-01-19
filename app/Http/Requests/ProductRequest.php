<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (Auth::user()->role == "gudang")
            return true;

        return false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'selling' => ['required'],
            "available" => ['present', 'array'],
            "stok" => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Produk Tidak Boleh Kosong',
            'price.required' => 'Harga Beli Tidak Boleh Kosong',
            'selling.required' => 'Harga Jual Tidak Boleh Kosong',
            'available.present' => "Kompatibel harus dipilih setidak nya satu",
            'stok.required' => 'Stok Tidak Boleh Kosong'
        ];
    }
}
