<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'sortBy' => Rule::in(['price']),
            'sortOrder' => Rule::in(['desc' , 'ase']),
        ];
    }

    public function messages()
    {
        return [
          'sortBy' => 'just price accepted'  ,
          'sortOrder' => "just 'desc' or 'ase' accepted"  ,
        ];
    }
}
