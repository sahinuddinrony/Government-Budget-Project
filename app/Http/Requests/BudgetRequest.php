<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BudgetRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fiscal_year' => 'required|string',
            // 'item_name' => 'required|string|max:255',
            // 'allocation' => 'required|numeric|min:0',
            // 'expenditure' => 'required|numeric|min:0',
            // 'unused' => 'required|numeric|min:0',
            'item_code' => 'required|array',
            'item_name' => 'required|array',
            // 'item_name.*' => 'required|string',
            'allocation' => 'required|array',
            // 'allocation.*' => 'required|numeric',
            'expenditure' => 'required|array',
            // 'expenditure.*' => 'required|numeric',
            // 'item_allocation' => 'required|array',
            // 'item_allocation.*' => 'required|numeric|min:0',
            // 'item_expenditure' => 'required|array',
            // 'item_expenditure.*' => 'required|numeric|min:0',
            // 'item_unused' => 'required|array',
            // 'item_unused.*' => 'required|numeric|min:0',
        ];
    }
}
