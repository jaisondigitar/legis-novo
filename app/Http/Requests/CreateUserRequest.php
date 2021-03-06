<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateUserRequest extends Request
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
                'required',
                'string',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'required|string',
            'roles' => 'required|array',
            'roles.*' => 'nullable|integer|exists:roles,id',
            'active' => ['nullable', Rule::in('on')],
        ];
    }
}
