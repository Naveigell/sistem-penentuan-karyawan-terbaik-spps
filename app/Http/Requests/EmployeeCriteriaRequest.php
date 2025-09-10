<?php

namespace App\Http\Requests;

use App\Models\Criteria;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeCriteriaRequest extends FormRequest
{
    private $criteria;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->createRules();
    }

    /**
     * Creates the rules for the request.
     *
     * This function creates the rules for the request. It iterates over the
     * criteria, and for each criterion, it appends the appropriate rule to the
     * rules array. The rules are of the form:
     *
     * - `required`
     * - `in_array:<comma-separated-list-of-option-ids>` for criteria with
     *   options
     * - `integer|min:<min>|max:<max>` for criteria with ranges
     * - `integer|min:1|max:1000000000000` for criteria with no value type
     *
     * @return array<string, string>
     */
    private function createRules()
    {
        $rules = [];

        $criteria = $this->criteria();

        foreach ($criteria as $criterion) {
            if ($criterion->value_type->isOption()) {
                $rules['criteria.' . $criterion->id] = "required|in:" . $criterion->options->pluck('id')->join(',');
            } else if ($criterion->value_type->isRange()) {
                $rules['criteria.' . $criterion->id] = "required|integer|min:" . $criterion->range->min . "|max:" . $criterion->range->max;
            } else {
                $rules['criteria.' . $criterion->id] = "required|integer|min:1|max:" . 1000_000_000_000;
            }
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $result = [];

        foreach ($this->criteria() as $criterion) {
            $result['criteria.' . $criterion->id] = $criterion->name;
        }

        return $result;
    }

    /**
     * Returns a collection of criteria models with their range and options loaded.
     *
     * This method is used internally to cache the criteria models in order to
     * create the validation rules dynamically.
     *
     * @return \Illuminate\Support\Collection<Criteria>
     */
    private function criteria()
    {
        if (!$this->criteria) {
            $this->criteria = Criteria::with('range', 'options')->get();
        }

        return $this->criteria;
    }
}
