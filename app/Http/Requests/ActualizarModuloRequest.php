<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarModuloRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:relevamiento,pausado,desarrollo,terminado',
            'proyecto_id' => 'required|exists:proyectos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser relevamiento, pausado, desarrollo o terminado.',
            'proyecto_id.required' => 'El proyecto es obligatorio.',
            'proyecto_id.exists' => 'El proyecto no existe.',
        ];
    }
}
