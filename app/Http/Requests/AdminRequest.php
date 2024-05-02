<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
        $id = explode("/", Request::getRequestUri());
        $id = end($id);
        return [
            "name" => "required|min:5",
            "email" => [
                "required",
                Rule::unique('users')->ignore($id),
            ],
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
