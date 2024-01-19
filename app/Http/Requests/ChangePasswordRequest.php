<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "old_password" => ['required', new MatchOldPassword],
            'password' => ['required', 'max:8', 'min:4'],
            'new_password' => ['same:password', 'required'],
        ];
    }
}
