<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (Auth::user()->role == "admin")
            return true;

        return false;
    }

    public function rules(): array
    {
        switch ($this->method()) {
            case "PUT":
                return [
                    'name' => ['required'],
                    'price' => ['required'],
                    'selling' => ['required'],
                    "available" => ['present', 'array'],
                    "stok" => ['required'],
                    "gambar" => ['mimes:jpg,jpeg,png']
                ];
                break;
            default:
                return [
                    'name' => ['required'],
                    'price' => ['required'],
                    'selling' => ['required'],
                    "available" => ['present', 'array'],
                    "stok" => ['required'],
                    "gambar" => ['required', 'mimes:jpg,jpeg,png']

                ];
                break;
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Produk Tidak Boleh Kosong',
            'price.required' => 'Harga Beli Tidak Boleh Kosong',
            'selling.required' => 'Harga Jual Tidak Boleh Kosong',
            'available.present' => "Kompatibel harus dipilih setidak nya satu",
            'stok.required' => 'Stok Tidak Boleh Kosong',
            'gambar.required' => 'Gambar Wajib Dimasukan'
        ];
    }
}
