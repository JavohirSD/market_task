<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'address'   => 'required|string||min:2|max:255',
            'schedule'  => 'required|string||min:2|max:128',
            'latitude'  => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',
            'status'    => 'required|numeric|digits:1,2',
        ];
    }
}
