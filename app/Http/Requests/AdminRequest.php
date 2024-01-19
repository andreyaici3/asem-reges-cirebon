<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        if (Auth::user()->role == "superadmin" || Auth::user()->role == "superuser" || Auth::user()->role == "admin")
            return true;

        return false;
    }

    public function rules()
    {
        return [
            "name" => "required|min:5",
            "email" => "required|email|unique:users",
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama Admin',
            "email" => "Email Admin",
        ];
    }
}
