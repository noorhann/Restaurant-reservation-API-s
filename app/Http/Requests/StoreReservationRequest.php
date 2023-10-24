<?php

namespace App\Http\Requests;

use App\Rules\FromTimeBeforeToTimeValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'table_id' => 'required|integer|exists:tables,id',
            'customer_id' => 'required|integer|exists:customers,id',
            'from_time' => 'required|date',
            'to_time' => ['required','date' ],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'The given data was invalid.',

            'data'      => $validator->errors()

        ], 400));
    }
}
