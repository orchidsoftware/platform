<?php

namespace Orchid\Http\Requests;

use Illuminate\Support\Facades\Auth;

class SettingsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key'   => 'required|unique:settings,key,' . $this->get('key'),
            'value' => 'required',
        ];
    }
}
