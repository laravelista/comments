<?php

namespace Laravelista\Comments\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    public function rules(): array
    {

        return [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer|min:1',
            'message' => 'required|string'
        ];
    }
}
