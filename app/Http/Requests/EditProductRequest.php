<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            "id" => "required",
            "name" => "required",
            "quantity" => "required"
        ];
    }


    public function messages(): array {
        return [
            "id.required" => "ID is required",
            "name.required" => "Name is required",
            "quantity.required" => "Quantity is required",
        ];
    }
}
