<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpace;
use App\Rules\CapitalizedWords;

class StoreOrderRequest extends CustomFormRequest
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
            'id' => 'required',
            'name' => ['required', 'string', new AlphaSpace(), new CapitalizedWords()],
            'address.city' => ['required', 'string'],
            'address.district' => ['required', 'string'],
            'address.street' => ['required', 'string'],
            'price' => ['required', 'numeric', 'max:2000', 'min:1'],
            'currency' => ['required', 'in:TWD,USD'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.max' => 'Price is over 2000.',
            'currency.in' => 'Currency is wrong.',
        ];
    }
}
