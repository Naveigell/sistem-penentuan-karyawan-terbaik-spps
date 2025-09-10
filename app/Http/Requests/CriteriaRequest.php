<?php

namespace App\Http\Requests;

use App\Enums\CriteriaValueType;
use App\Utils\DecisionSupportSystem\Enums\CriteriaType;
use Illuminate\Foundation\Http\FormRequest;

class CriteriaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'weight'     => 'required|numeric',
            'type'       => 'required|in:' . implode(',', array_column(CriteriaType::cases(), 'value')),
            'value_type' => 'required|in:' . implode(',', array_column(CriteriaValueType::cases(), 'value')),
        ];
    }
}
