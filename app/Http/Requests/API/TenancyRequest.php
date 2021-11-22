<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class TenancyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:15',
        ];
    }
}
