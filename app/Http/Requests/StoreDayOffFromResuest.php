<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDayOffFromResuest extends FormRequest
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
        return [
            'username' => 'required|min:3|max:255',
            'userid' => 'required',
            'phone' => 'required',
            'position' => 'required',
            'section' => 'required',
            'branch' => 'required',
            'dateout' => 'required',
            'timeout' => 'required',
            'datein' => 'required',
            'timein' => 'required',
            'request_to' => 'required',
            'type' => 'required',
            'reason' => 'required|min:3|max:1000',
        ];
    }
}
