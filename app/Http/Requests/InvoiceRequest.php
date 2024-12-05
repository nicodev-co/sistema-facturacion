<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'status' => 'required|string',
            'details' => 'required|array',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|numeric',
            'details.*.price' => 'required|numeric',
            'details.*.total' => 'required|numeric',
        ];
    }
}
