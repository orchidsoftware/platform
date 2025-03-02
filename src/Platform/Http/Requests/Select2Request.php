<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Select2Request extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search'         => 'string|nullable',
            'key'            => 'string|required',
            'display'        => 'string|required',
        ];
    }
}
