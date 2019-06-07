<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Gate::denies('product')) {
            abort(403);
        }
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
            "user_id"=>"required|integer",
            "name"=>"required",
        ];        
    }
    public function messages()
    {
        return [
            'user_id.required' => 'El proveedor es obligatorio.',
            'user_id.integer' => 'El proveedor seleccionada no es correcto.',
            'name.required' => 'El nombre es obligatorio.',
        ];
    }
}
