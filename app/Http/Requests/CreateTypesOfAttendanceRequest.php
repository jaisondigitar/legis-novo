<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TypesOfAttendance;

class CreateTypesOfAttendanceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->ajax()) {
            return [
                'name' => 'nullable',
                'active' => 'required',
            ];
        }

        return TypesOfAttendance::$rules;
    }
}
