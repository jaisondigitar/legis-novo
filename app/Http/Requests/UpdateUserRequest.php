<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateUserRequest extends Request
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
            'sector_id' => 'required|integer|exists:sectors,id',
            'company_id' => 'required|integer|exists:companies,id',
            'name' => 'required|string',
            'email' => [
                'nullable',
                'string',
                Rule::exists('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'nullable|string',
            'roles' => 'required|array',
            'roles.*' => 'nullable|integer|exists:roles,id',
            'active' => ['nullable', Rule::in('on')],
        ];
    }
}
