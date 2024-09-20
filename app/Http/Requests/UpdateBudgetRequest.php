<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
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
            'fiscal_year' => 'required',
            // 'items' => 'required|array',
            'items.*.id' => 'sometimes|exists:items,id',
            'items.*.item_code' => 'required',
            'items.*.item_name' => 'required',
            'items.*.item_allocation' => 'required|numeric',
            'items.*.item_expenditure' => 'required|numeric',
            'items.*.item_unused' => 'required|numeric',
        ];
    }
}
