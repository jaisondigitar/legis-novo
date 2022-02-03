<?php

namespace App\Http\Requests;

use App\Models\Attendance;

class UpdateAttendanceRequest extends Request
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
                'date_exit' => 'required',
                'time_exit' => 'required',
            ];
        }

        return Attendance::$rules;
    }
}
