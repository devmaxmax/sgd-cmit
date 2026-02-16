<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarAvanceRequest extends FormRequest
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
            'ticket_id' => 'required|exists:tickets,id',
            'observacion' => 'required|string',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'ticket_id' => $this->route('id')
        ]);
    }

    public function messages(): array
    {
        return [
            'ticket_id.required' => 'El ticket es requerido',
            'ticket_id.exists' => 'El ticket no existe',
            'observacion.required' => 'La observacion es requerida',
        ];
    }
}
