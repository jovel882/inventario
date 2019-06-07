<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Gate::denies('order')) {
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
            "date"=>"required|date|date_format:Y-m-d",
            "data_Product"=>"required",
        ];        
    }
    public function messages()
    {
        return [
            'user_id.required' => 'El proveedor es obligatorio.',
            'user_id.integer' => 'El proveedor seleccionada no es correcto.',
            'date.required' => 'La fecha para la orden es obligatoria.',
            'date.date' => 'La fecha para la orden no es valida.',
            'date.date_format' => 'La fecha para la orden no es valida con el formato yyyy-mm-dd.',            
            'data_Product.required' => 'Los productos son requeridos.',
        ];
    }
}
