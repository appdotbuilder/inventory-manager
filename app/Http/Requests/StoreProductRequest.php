<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'barcode' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'This SKU already exists in the system.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'supplier_id.required' => 'Please select a supplier.',
            'supplier_id.exists' => 'Selected supplier is invalid.',
            'cost_price.required' => 'Cost price is required.',
            'selling_price.required' => 'Selling price is required.',
            'reorder_level.required' => 'Reorder level is required.',
            'current_stock.required' => 'Current stock is required.',
            'unit.required' => 'Unit of measurement is required.',
        ];
    }
}